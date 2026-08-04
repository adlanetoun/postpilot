<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CreditTransactionResource\Pages\ListCreditTransactions;
use App\Models\CreditTransaction;
use BackedEnum;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Collection;

class CreditTransactionResource extends Resource
{
    protected static ?string $model = CreditTransaction::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBanknotes;

    protected static ?string $recordTitleAttribute = 'description';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('user_id')
                ->relationship('user', 'email')
                ->required()
                ->searchable(),
            Select::make('type')
                ->options([
                    'purchase' => 'Purchase',
                    'consumption' => 'Consumption',
                    'refund' => 'Refund',
                    'manual_adjustment' => 'Manual Adjustment',
                    'technical_refund' => 'Technical Refund',
                ])
                ->required(),
            TextInput::make('amount')
                ->required()
                ->numeric(),
            TextInput::make('description')
                ->required()
                ->maxLength(255),
            TextInput::make('reference_type')
                ->maxLength(255),
            TextInput::make('reference_id')
                ->numeric(),
            TextInput::make('ip_address')
                ->maxLength(45),
            TextInput::make('user_agent')
                ->maxLength(512),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.email')
                    ->label('User')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('type')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'purchase' => 'success',
                        'consumption' => 'warning',
                        'refund' => 'info',
                        'manual_adjustment' => 'gray',
                        'technical_refund' => 'info',
                        default => 'gray',
                    })
                    ->sortable(),
                TextColumn::make('amount')
                    ->numeric()
                    ->sortable()
                    ->color(fn (int $state): string => $state >= 0 ? 'success' : 'danger'),
                TextColumn::make('balance_after')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('description')
                    ->searchable()
                    ->limit(50),
                TextColumn::make('ip_address')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('flagged_for_review')
                    ->badge()
                    ->color(fn (bool $state): string => $state ? 'danger' : 'gray')
                    ->formatStateUsing(fn (bool $state): string => $state ? 'Flagged' : '—')
                    ->toggleable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('type')
                    ->options([
                        'purchase' => 'Purchase',
                        'consumption' => 'Consumption',
                        'refund' => 'Refund',
                        'manual_adjustment' => 'Manual Adjustment',
                        'technical_refund' => 'Technical Refund',
                    ])
                    ->multiple(),
                SelectFilter::make('user')
                    ->relationship('user', 'email')
                    ->searchable()
                    ->multiple(),
                Filter::make('created_at')
                    ->form([
                        DatePicker::make('from'),
                        DatePicker::make('to'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['from'] ?? null, fn ($q, $date) => $q->whereDate('created_at', '>=', $date))
                            ->when($data['to'] ?? null, fn ($q, $date) => $q->whereDate('created_at', '<=', $date));
                    }),
                \Filament\Tables\Filters\TernaryFilter::make('flagged_for_review')
                    ->label('Review Status')
                    ->placeholder('All transactions')
                    ->trueLabel('Flagged only')
                    ->falseLabel('Not flagged')
                    ->queries(
                        true: fn ($query) => $query->where('flagged_for_review', true),
                        false: fn ($query) => $query->where('flagged_for_review', false),
                        blank: fn ($query) => $query,
                    ),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    BulkAction::make('manual_adjustment')
                        ->label('Manual Adjustment')
                        ->icon('heroicon-o-plus-circle')
                        ->requiresConfirmation()
                        ->form([
                            TextInput::make('amount')
                                ->required()
                                ->numeric()
                                ->helperText('Positive to add, negative to deduct'),
                            TextInput::make('reason')
                                ->required()
                                ->maxLength(255),
                        ])
                        ->action(function (Collection $records, array $data) {
                            foreach ($records as $record) {
                                $user = $record->user;
                                if (! $user) {
                                    continue;
                                }
                                $user->addCampaignCredits(
                                    amount: (int) $data['amount'],
                                    type: 'manual_adjustment',
                                    description: "Bulk adjustment: {$data['reason']}",
                                    referenceType: CreditTransaction::class,
                                    referenceId: $record->id,
                                    metadata: ['source' => 'admin_bulk_action'],
                                );
                            }
                            Notification::make()
                                ->title('Manual adjustment applied')
                                ->success()
                                ->send();
                        }),
                    BulkAction::make('flag_for_review')
                        ->label('Flag for Review')
                        ->icon('heroicon-o-flag')
                        ->color('warning')
                        ->requiresConfirmation()
                        ->action(function (Collection $records) {
                            $records->each->update([
                                'flagged_for_review' => true,
                                'flag_reason' => 'Flagged by admin via bulk action',
                            ]);
                            Notification::make()
                                ->title("Flagged {$records->count()} transaction(s)")
                                ->success()
                                ->send();
                        }),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCreditTransactions::route('/'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }
}
