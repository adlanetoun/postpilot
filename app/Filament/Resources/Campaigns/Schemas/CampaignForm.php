<?php

namespace App\Filament\Resources\Campaigns\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class CampaignForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('project_id')
                    ->required()
                    ->numeric(),
                TextInput::make('status')
                    ->required()
                    ->default('draft'),
                TextInput::make('raw_llm_payload_path'),
                Textarea::make('error_message')
                    ->columnSpanFull(),
            ]);
    }
}
