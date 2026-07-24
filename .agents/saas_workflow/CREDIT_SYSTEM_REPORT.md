# 📊 التقرير الشامل: نظام الكريديت (Credit-Based) في منصات SaaS

> **الإصدار:** 1.0 | **التاريخ:** يوليو 2026 | **المنصة المرجعية:** PostPilot (auto-30-engine)
> **النموذج:** Pay-Per-Action / Credit-Based (بديل عن الاشتراك الشهري التقليدي)

---

## 📑 جدول المحتويات

1. [Credit Visibility & Transparency — رؤية الرصيد والشفافية](#1-credit-visibility--transparency)
2. [The UX of Consumption — تجربة الاستهلاك (الاحتكاك مقابل الثقة)](#2-the-ux-of-consumption)
3. [Refunds, Revokes & Edge Cases — الاسترداد والإلغاء والحالات الحدية](#3-refunds-revokes--edge-cases)
4. [Essential Features Often Forgotten — الميزات المنسية](#4-essential-features-often-forgotten)
5. [Psychology of Credits — سيكولوجية الكريديت](#5-psychology-of-credits)
6. [Final Checklist — قائمة التطبيق الإلزامية](#6-final-checklist)

---

## 1. Credit Visibility & Transparency

### 1.1 السؤال الجوهري: هل يجب أن يكون الرصيد مرئياً دائماً؟

**الإجابة القصيرة: نعم، دائماً.** في نظام Credit-Based، الرصيد هو "الأكسجين" الذي يتنفسه المستخدم. إخفاؤه يخلق قلقاً مستمراً ("هل لدي ما يكفي؟") ويرسل رسالة خاطئة بأن المنصة تحاول إخفاء التكاليف.

### 1.2 معايير الصناعة (Industry Standards)

| المنصة | مكان عرض الرصيد | النمط |
|--------|-----------------|-------|
| **Vercel** | Top navbar (يمين) | Pill badge مع أيقونة + رقم |
| **Replicate** | Top navbar (يمين) | رصيد بالدولار + progress bar |
| **OpenAI API** | Dashboard sidebar | Usage card مع رسم بياني |
| **Twilio** | Top navbar (يمين) | Dollar amount باللون الأخضر |
| **HuggingFace** | Settings → Billing | مخفي (لكنه API-oriented) |
| **Midjourney** | /info command | ساعات Fast time المتبقية |

**القاعدة العامة:** كلما كان المستخدم أقرب إلى لحظة الاستهلاك، يجب أن يكون الرصيد أكثر وضوحاً.

### 1.3 أنماط العرض الموصى بها

#### النمط A: Persistent Pill Badge (الموصى به لـ PostPilot)

```
┌─────────────────────────────────────────────────────┐
│  [Logo]   Dashboard   Projects    [⚡ 3 Credits] [👤] │
└─────────────────────────────────────────────────────┘
```

- **الموقع:** أعلى الـ navbar أو في الـ sidebar
- **الشكل:** Pill-shaped badge مع أيقونة برق ⚡ أو عملة 🪙
- **اللون:**
  - رصيد صحي (≥3): خلفية شفافة أو رمادية فاتحة، نص داكن
  - رصيد منخفض (1-2): خلفية صفراء/برتقالية فاتحة (تحذير)
  - رصيد صفري (0): خلفية حمراء فاتحة + وميض خفيف + رابط مباشر للشراء

#### النمط B: Contextual Credit Display

عرض الرصيد **بالقرب من زر الإجراء** الذي يستهلك الكريديت:

```
┌──────────────────────────────────┐
│  Campaign Preview                │
│  ──────────────────────────────  │
│  ⚡ This action costs 1 credit   │
│  Your balance: 3 credits         │
│                                  │
│  [Approve & Launch (1 credit)]   │
└──────────────────────────────────┘
```

### 1.4 أفضل الممارسات للعرض الديناميكي

| الممارسة | الوصف | الأولوية |
|----------|-------|----------|
| **تحديث فوري بعد الشراء** | عند نجاح webhook الدفع، حدّث الرصيد بدون reload كامل | Critical |
| **تحديث فوري بعد الاستهلاك** | بعد خصم كريديت، حدّد الرقم فوراً (optimistic UI) | Critical |
| **Animation عند التغيير** | Count-up/down animation عند زيادة/نقصان الرصيد | High |
| **Tooltip عند الـ hover** | "آخر تحديث: منذ 5 دقائق" أو "انقر لإدارة الكريديت" | Medium |
| **Color coding ديناميكي** | تغيير لون الـ badge حسب الرصيد (أخضر → أصفر → أحمر) | High |
| **Real-time sync** | WebSocket أو polling كل 30 ثانية لتحديث الرصيد | Medium |

### 1.5 توصيات محددة لـ PostPilot

**المشكلة الحالية:** الرصيد يظهر **فقط** في صفحة `/settings?tab=billing`. المستخدم في صفحة `projects/show.blade.php` لا يرى رصيده إلا إذا فتح الإعدادات.

**الإصلاحات المطلوبة:**

1. **إضافة Credit Pill Badge في الـ sidebar** (`resources/views/layouts/sidebar.blade.php`):
   - عرض `auth()->user()->campaign_credits` بشكل دائم
   - رابط مباشر لصفحة الفوترة عند النقر
   - تغيير اللون ديناميكياً حسب الرصيد

2. **إضافة Credit Display في الـ navbar** (`resources/views/layouts/navigation.blade.php`):
   - Badge مدمج بجانب صورة المستخدم
   - تحديث عبر JavaScript عند نجاح/فشل الإجراءات

3. **عرض الرصيد في الـ Dashboard** (`resources/views/dashboard.blade.php`):
   - بطاقة "Credit Balance" مع تاريخ آخر استخدام
   - رابط سريع لشراء المزيد

---

## 2. The UX of Consumption

### 2.1 مبدأ "Pre-Action Transparency" (الشفافية قبل الإجراء)

**القاعدة الذهبية:** المستخدم يجب أن يعرف **دائماً** أن إجراءً ما سيكلفه كريديت **قبل** أن يضغط الزر — وليس بعد.

### 2.2 مستويات التأكيد (Confirmation Levels)

| المستوى | متى يُستخدم | النمط | مثال |
|--------|-------------|-------|------|
| **Level 0: Inline Cost Label** | كل إجراء يستهلك كريديت | النص على الزر يتضمن التكلفة | `[Approve & Launch (1 Credit)]` |
| **Level 1: Soft Confirm** | إجراءات منخفضة المخاطر | Modal بسيط بـ "Confirm/Cancel" | تأكيد إنشاء حملة |
| **Level 2: Hard Confirm** | إجراءات مكلفة أو غير قابلة للتراجع | Modal مع تفاصيل + تأكيد مكتوب | حذف حملة نشطة |
| **Level 3: Double Opt-In** | إجراءات حساسة جداً | Modal + checkbox "I understand" | شراء حزمة كبيرة |

### 2.3 أنماط الـ Confirmation Modals

#### النمط A: Cost Preview Modal (الموصى به قبل الخصم)

```
┌─────────────────────────────────────────┐
│  ⚡ Confirm Credit Usage                 │
│  ──────────────────────────────────────  │
│                                         │
│  You are about to:                      │
│  • Approve & Launch your 30-day campaign│
│                                         │
│  Cost: 1 Credit                         │
│  Current balance: 3 credits             │
│  Balance after: 2 credits               │
│                                         │
│  ┌─────────────────────────────────┐    │
│  │ ⚠️ Credits are non-refundable   │    │
│  │ once posts are published.       │    │
│  └─────────────────────────────────┘    │
│                                         │
│         [Cancel]  [Confirm & Launch]    │
└─────────────────────────────────────────┘
```

**العناصر الحرجة في الـ Modal:**
1. **ماذا سيحدث** (الإجراء بوضوح)
2. **التكلفة** (كم كريديت)
3. **الرصيد الحالي** (قبل العملية)
4. **الرصيد المتوقع** (بعد العملية)
5. **تحذير الاسترداد** (متى لا يمكن الاسترداد)
6. **زر إلغاء واضح** (يسار، بلون محايد)
7. **زر تأكيد واضح** (يمين، بلون أساسي)

#### النمط B: Insufficient Credits Modal (عند عدم وجود رصيد كافٍ)

```
┌─────────────────────────────────────────┐
│  ⚠️ Insufficient Credits                 │
│  ──────────────────────────────────────  │
│                                         │
│  This action requires 1 credit.         │
│  Your current balance: 0 credits.        │
│                                         │
│  To continue, purchase credits below:    │
│                                         │
│  ┌─────────┐ ┌─────────┐ ┌─────────┐   │
│  │ 1 Credit│ │ 3 Credits│ │10 Credits│  │
│  │  $9.99  │ │ $25.99  │ │ $69.99   │  │
│  │ [Buy]   │ │ [Buy]★  │ │ [Buy]    │  │
│  └─────────┘ └─────────┘ └─────────┘   │
│                                         │
│              [Maybe Later]               │
└─────────────────────────────────────────┘
```

### 2.4 متى نستخدم Modal ومتى نستخدم Inline Warning

| الحالة | النهج | السبب |
|--------|-------|-------|
| قبل خصم كريديت (Approve) | **Modal** | إجراء لا رجعة فيه، يحتاج تأكيد صريح |
| قبل توليد حملة (Generate) | **Inline label** | التوليد مجاني، الخصم عند الموافقة |
| عند نفاد الرصيد | **Modal + Buy options** | احتكاك منخفض، عرض حل فوري |
| عند محاولة إجراء بدون رصيد | **Redirect + Banner** | تعليم المستخدم بدلاً من إحباطه |

### 2.5 تحليل حالة PostPilot الحالية

**المشكلة الحرجة:** في `projects/show.blade.php`، زر "Approve & Launch" **لا يعرض** أن الإجراء سيكلف كريديت، ولا يوجد modal تأكيد. المستخدم يضغط الزر ثم يكتشف (عبر redirect) أنه إما:
- تم خصم الكريديت (مفاجأة!)
- تم رفض الإجراء لعدم وجود رصيد (إحباط!)

**الإصلاحات المطلوبة:**

1. **في Step 4 (Review) من الـ wizard:** إضافة سطر واضح:
   ```
   Cost: 1 Credit (deducted on approval)
   Your balance: X credits
   ```

2. **قبل زر "Approve & Launch":** إضافة Cost Preview Modal:
   - عرض التكلفة والرصيد الحالي والمتوقع
   - تحذير واضح عن سياسة الاسترداد
   - زر تأكيد صريح

3. **عند عدم وجود رصيد:** استبدال الـ redirect المباشر بـ Insufficient Credits Modal يعرض خيارات الشراء داخل نفس الصفحة (بدون مغادرة السياق)

### 2.6 معايير الرسائل التحذيرية

| الرسالة | متى | النمط |
|---------|-----|-------|
| "This action will use 1 credit. Continue?" | قبل أي خصم | Modal + Confirm |
| "You have 0 credits. Purchase to continue." | عند نفاد الرصيد | Modal + Buy options |
| "Credits are non-refundable after publishing." | قبل الإجراء غير القابل للتراجع | Warning box داخل Modal |
| "1 credit refunded — no posts were published." | بعد استرداد ناجح | Success toast/banner |
| "Generation failed — no credits were charged." | بعد فشل التوليد | Info banner |

---

## 3. Refunds, Revokes & Edge Cases

### 3.1 المعيار الصناعي: Auto-Refund vs. No-Refund

هناك مدرستان فلسفيتان في الصناعة:

#### المدرسة A: Auto-Refund (الاسترداد التلقائي)

**الفلسفة:** إذا لم يحصل المستخدم على قيمة فعلية، استرد الكريديت تلقائياً.

| المزايا | العيوب |
|---------|--------|
| ✅ يبني ثقة عالية | ❌ قابل للإساءة (abuse) |
| ✅ يقلل شكاوى العملاء | ❌ منطق معقد، bugs أكثر |
| ✅ "Fair Use" perception | ❌ قد يشجع على التجريب المفرط |
| ✅ يقلل chargebacks | ❌ صعوبة التدقيق (audit) |

**منصات تستخدم هذا:** Vercel (partial), Replicate (failed API calls), OpenAI (failed completions)

#### المدرسة B: Strict No-Refund (لا استرداد)

**الفلسفة:** الكريديت يُخصم عند بدء الإجراء، بغض النظر عن النتيجة. التحذيرات الصريحة كافية.

| المزايا | العيوب |
|---------|--------|
| ✅ منطق بسيط، bugs أقل | ❌ يخلق استياء عند الفشل |
| ✅ لا يمكن إساءة استخدامه | ❌ قد يزيد chargebacks |
| ✅ تدقيق مالي واضح | ❌ يقلل الثقة في المنصة |
| ✅ قابلية التنبؤ | ❌ "I paid for nothing" complaints |

**منصات تستخدم هذا:** Midjourney (Fast hours consumed regardless), بعض API providers

### 3.2 النموذج الهجين الموصى به (Hybrid Model)

**هذا ما تطبقه PostPilot بالفعل — وهو النهج الصحيح.** إليك التحليل:

```
┌────────────────────────────────────────────────────────────┐
│                    دورة حياة الكريديت                       │
│                                                            │
│  [Generate Campaign] ──→ مجاني (لا خصم)                    │
│         │                                                  │
│         ▼                                                  │
│  [Campaign Generated] ──→ معاينة مجانية                    │
│         │                                                  │
│         ▼                                                  │
│  [Approve & Launch] ──→ خصم 1 كريديت 💰                    │
│         │                                                  │
│    ┌────┴────┐                                             │
│    │         │                                             │
│    ▼         ▼                                             │
│  [Published] [Revoke/Delete before publish]                │
│    │         │                                             │
│    │         └─→ استرداد 1 كريديت ✅ (Fair Use)            │
│    │                                                       │
│    └─→ لا استرداد ❌ (تم تقديم القيمة)                      │
└────────────────────────────────────────────────────────────┘
```

**لماذا هذا النهج هو الأفضل:**

1. **التوليد مجاني** → يزيل "spending anxiety" الأولي
2. **الخصم عند الموافقة** → المستخدم يرى النتيجة أولاً ثم يقرر الدفع
3. **استرداد قبل النشر** → "Fair Use" يبني الثقة
4. **لا استرداد بعد النشر** → القيمة تم تقديمها فعلاً

### 3.3 تحليل كود PostPilot الحالي

**ما يعمل بشكل صحيح:**

```php
// CampaignController@destroy — استرداد عند الحذف قبل النشر
if (in_array($campaign->status, ['active', 'paused'])) {
    $hasPublished = $campaign->posts()->whereIn('status', ['published', 'publishing'])->exists();
    if (!$hasPublished) {
        $campaign->project->user->addCampaignCredits(1);
        $refundMessage = ' 1 Credit has been refunded to your balance since no posts were published.';
    }
}

// CampaignController@revokeApproval — استرداد عند إلغاء الموافقة
DB::transaction(function () use ($campaign) {
    $campaign->update(['status' => 'completed']);
    $campaign->posts()->update(['status' => 'draft', 'scheduled_at' => null, 'social_account_id' => null]);
    $campaign->project->user->addCampaignCredits(1);
});
```

**الفجوات المكتشفة:**

| الفجوة | المخاطر | الإصلاح |
|--------|---------|---------|
| لا يوجد `CreditTransaction` ledger | لا يمكن تدقيق حركات الكريديت | إنشاء جدول `credit_transactions` |
| الاسترداد لا يُسجل في ledger | فقدان التتبع المالي | تسجيل كل خصم/استرداد/شراء |
| لا يوجد حد أقصى للاسترداد | قد يُساء الاستخدام | حد يومي/شهري للاستردادات |
| فشل التوليد لا يُعالج بوضوح | مستخدم محبط بدون توضيح | رسائل واضحة + إعادة المحاولة |
| لا يوجد timeout للكريديت المحجوز | كريديت عالق في حالة وسطية | auto-release بعد فترة |

### 3.4 Edge Cases الحرجة

#### Edge Case 1: فشل التوليد بعد الخصم

```
السيناريو: المستخدم يوافق على حملة (خصم 1 كريديت)، لكن فشل جدولة المنشورات
المعيار: استرداد تلقائي + رسالة واضحة
```

**التوصية:** إذا فشل `approve()` بعد خصم الكريديت (مثلاً: خطأ في API التواصل الاجتماعي)، يجب:
1. استرداد الكريديت تلقائياً داخل `catch` block
2. عرض رسالة: "Approval failed — 1 credit refunded. Please try again."
3. تسجيل الحادثة في الـ ledger

#### Edge Case 2: Race Condition في الاسترداد

```
السيناريو: مستخدم يضغط "Delete" و"Revoke" في نفس الوقت
المخاطر: استرداد مزدوج (2 كريديت بدلاً من 1)
```

**التوصية:** استخدام `DB::transaction` + atomic check (كما يفعل `decrementCampaignCredit` بالفعل). إضافة:
```php
// Atomic refund: تحقق من الحالة قبل الاسترداد
$updated = Campaign::where('id', $campaign->id)
    ->whereIn('status', ['active', 'paused'])
    ->update(['status' => 'completed']);
if ($updated > 0) {
    $user->addCampaignCredits(1);
}
```

#### Edge Case 3: الكريديت المشترى أثناء الجلسة

```
السيناريو: المستخدم يفتح صفحة الموافقة (رصيده 0)، يفتح tab جديد ويشتري كريديت،
يعود للصفحة الأولى ويضغط Approve
المخاطر: الصفحة الأولى لا تعرف بالرصيد الجديد
```

**التوصية:**
1. التحقق من الرصيد في الـ backend دائماً (لا تعتمد على الـ frontend)
2. تحديث الـ UI عبر polling أو WebSocket عند تغير الرصيد
3. رسالة واضحة: "Your balance was updated! You now have X credits."

#### Edge Case 4: انتهاء صلاحية الكريديت

```
السيناريو: كريديت مشترى لكن لم يُستخدم منذ 12 شهراً
السؤال: هل ينتهي؟
```

**معايير الصناعة:**
- **Vercel/Replicate:** لا انتهاء صلاحية (credits don't expire)
- **بعض المنصات:** تنتهي بعد 12-24 شهراً
- **التوصية لـ PostPilot:** لا انتهاء صلاحية (يبني الثقة)، لكن أضف إشعار "inactive credits" بعد 12 شهراً لتحفيز الاستخدام

### 3.5 سياسة الاسترداد الموصى بها (Refund Policy)

```
┌──────────────────────────────────────────────────────────┐
│              PostPilot Credit Refund Policy               │
│                                                          │
│  ✅ AUTO-REFUND (تلقائي):                                │
│     • فشل توليد الحملة (API error)                        │
│     • حذف حملة نشطة قبل نشر أي منشور                      │
│     • إلغاء موافقة قبل نشر أي منشور                        │
│     • فشل جدولة المنشورات بعد الخصم                       │
│                                                          │
│  ❌ NO REFUND (لا استرداد):                              │
│     • تم نشر منشور واحد على الأقل                        │
│     • انتهت الحملة بشكل طبيعي (30 يوم)                    │
│     • شراء كريديت ثم عدم استخدامه (لا انتهاء صلاحية)      │
│                                                          │
│  ⚠️ MANUAL REVIEW (مراجعة يدوية):                        │
│     • طلب استرداد نقدي (cash refund)                     │
│     • شكوى في أداء جودة المحتوى المولّد                   │
│     • اكتشاف bug أدى لخصم خاطئ                            │
└──────────────────────────────────────────────────────────┘
```

---

## 4. Essential Features Often Forgotten

### 4.1 خريطة الميزات المنسية

```
                    ┌─────────────────┐
                    │  Credit System  │
                    │   Core Engine   │
                    └────────┬────────┘
                             │
          ┌──────────────────┼──────────────────┐
          │                  │                  │
    ┌─────┴─────┐    ┌──────┴──────┐   ┌──────┴──────┐
    │  Tracking  │    │ Notifications│   │   Admin     │
    │  & Audit   │    │   & Alerts   │   │  & Support  │
    └─────┬─────┘    └──────┬──────┘   └──────┬──────┘
          │                  │                  │
    ┌─────┴─────┐    ┌──────┴──────┐   ┌──────┴──────┐
    │• Ledger    │    │• Low balance│   │• Admin panel│
    │• Usage hist│    │• Purchase   │   │• Manual adj │
    │• Receipts  │    │• Consumption│   │• Fraud det  │
    │• Export    │    │• Expiry     │   │• Reports    │
    └───────────┘    └─────────────┘   └─────────────┘
```

### 4.2 الميزة #1: Credit Transaction Ledger (سجل المعاملات)

**المشكلة:** حالياً، `campaign_credits` هو مجرد رقم في جدول `users`. لا يوجد سجل لـ "من أين أتى الكريديت وأين ذهب".

**الحل:** إنشاء جدول `credit_transactions`:

```
credit_transactions
├── id (uuid)
├── user_id (FK)
├── type (enum: purchase, consumption, refund, admin_adjustment, expiry)
├── amount (integer, +ve for credit, -ve for debit)
├── balance_after (integer)
├── description (string)
├── reference_type (nullable, e.g., Campaign::class)
├── reference_id (nullable, e.g., campaign_id)
├── metadata (json, e.g., webhook_payload, payment_id)
├── created_at
└── updated_at
```

**أمثلة على السجلات:**

| type | amount | balance_after | description | reference |
|------|--------|---------------|-------------|-----------|
| purchase | +3 | 3 | Growth Pack purchased ($25.99) | Webhook #123 |
| consumption | -1 | 2 | Campaign approved & launched | Campaign #45 |
| refund | +1 | 3 | Campaign deleted before publishing | Campaign #45 |
| admin_adjustment | +5 | 8 | Support ticket #789 — goodwill credit | — |

**الفوائد:**
- ✅ تدقيق مالي كامل (audit trail)
- ✅ كشف الاحتيال (fraud detection)
- ✅ دعم العملاء (يمكن للمستخدم رؤية تاريخه)
- ✅ إصلاح الأخطاء (إذا فُقد كريديت، يمكن تتبعه)
- ✅ تقارير الإدارة (revenue, usage patterns)

### 4.3 الميزة #2: Low Credit Threshold Alerts

**المشكلة:** المستخدم يكتشف نفاد رصيده فقط عند محاولة الإجراء — لحظة إحباط قصوى.

**الحل:** نظام تنبيهات استباقي متعدد المستويات:

| الحد | الإجراء | القناة |
|-----|---------|--------|
| رصيد ≤ 2 | Banner في الـ dashboard | In-app |
| رصيد ≤ 1 | Toast notification + email | In-app + Email |
| رصيد = 0 | Modal blocking + email | In-app + Email |
| رصيد = 0 + محاولة إجراء | Modal مع خيارات شراء | In-app |

**نموذج الإيميل:**
```
Subject: ⚡ Your PostPilot credits are running low

Hi {name},

You have {credits} credit(s) remaining on your PostPilot account.

Don't let your campaigns pause — top up now:
[Buy Credits →]

Best,
The PostPilot Team
```

### 4.4 الميزة #3: Usage/Billing History Screen

**المشكلة:** لا توجد صفحة لمراجعة تاريخ الاستخدام والشراء.

**الحل:** صفحة `/settings?tab=usage` تعرض:

```
┌─────────────────────────────────────────────────────┐
│  📊 Usage & Billing History                          │
│  ───────────────────────────────────────────────────│
│                                                     │
│  [Filter: All | Purchases | Usage | Refunds]        │
│  [Date Range: Last 30 days ▼]                       │
│                                                     │
│  ┌───────────────────────────────────────────────┐  │
│  │ Jul 17, 2026  •  Purchase                     │  │
│  │ Growth Pack — 3 credits                       │  │
│  │ Amount: $25.99  |  Balance: 0 → 3             │  │
│  │ [Download Receipt]                            │  │
│  └───────────────────────────────────────────────┘  │
│                                                     │
│  ┌───────────────────────────────────────────────┐  │
│  │ Jul 16, 2026  •  Consumption                 │  │
│  │ Campaign "Summer Launch" approved             │  │
│  │ Cost: 1 credit  |  Balance: 3 → 2            │  │
│  └───────────────────────────────────────────────┘  │
│                                                     │
│  ┌───────────────────────────────────────────────┐  │
│  │ Jul 15, 2026  •  Refund                       │  │
│  │ Campaign deleted before publishing            │  │
│  │ Refund: +1 credit  |  Balance: 2 → 3          │  │
│  └───────────────────────────────────────────────┘  │
│                                                     │
│  [Export CSV]  [Export PDF]                         │
└─────────────────────────────────────────────────────┘
```

### 4.5 الميزة #4: Empty States احترافية

**المشكلة:** عندما رصيد المستخدم = 0، التجربة تتوقف بجدران حمراء بدون إرشاد.

**الحل:** Empty states مصممة بعناية:

#### Empty State A: رصيد صفري + لا توجد حملات

```
┌─────────────────────────────────────────┐
│                                         │
│          🪙 (أيقونة كبيرة)              │
│                                         │
│      No Credits Yet                     │
│                                         │
│  You need credits to launch AI          │
│  campaigns. Your first campaign          │
│  is FREE — no credit needed!            │
│                                         │
│  [Start Your Free Campaign →]           │
│                                         │
│  Or buy credits:                        │
│  [1 for $9.99] [3 for $25.99] [10 for $69.99] │
│                                         │
└─────────────────────────────────────────┘
```

#### Empty State B: رصيد صفري + محاولة إجراء

```
┌─────────────────────────────────────────┐
│  ⚠️ You're out of credits!              │
│                                         │
│  Your campaign is ready to launch,      │
│  but you need 1 credit to approve it.   │
│                                         │
│  Don't worry — your campaign is saved   │
│  and ready to go.                       │
│                                         │
│  [Buy 1 Credit ($9.99) →]               │
│  [Buy 3 Credits ($25.99) — Save 13% →]  │
│                                         │
│  [Keep Campaign as Draft]               │
└─────────────────────────────────────────┘
```

### 4.6 الميزة #5: Email Notifications

| الحدث | الموضوع | المحتوى |
|-------|---------|---------|
| شراء كريديت | ✅ Purchase confirmed | تفاصيل الحزمة + الرصيد الجديد + رابط الإيصال |
| استهلاك كريديت | ⚡ Credit used | تفاصيل الحملة + الرصيد المتبقي |
| استرداد كريديت | ↩️ Credit refunded | سبب الاسترداد + الرصيد الجديد |
| رصيد منخفض | ⚠️ Low credits warning | الرصيد الحالي + رابط الشراء |
| رصيد صفري | 🚫 Out of credits | تأثير على الحملات النشطة + رابط الشراء |
| فشل دفع | ❌ Payment failed | سبب الفشل + إعادة المحاولة |

### 4.7 الميزة #6: Admin Dashboard لمراقبة الكريديت

**لـ Filament Admin Panel:**

- **Credit Overview Widget:** إجمالي الكريديت المباع، المستهلك، المسترد
- **Revenue Chart:** الإيرادات اليومية/الشهرية من بيع الكريديت
- **User Credit List:** جميع المستخدمين مع أرصدتهم وآخر نشاط
- **Manual Adjustment:** إضافة/خصم كريديت يدوياً (مع سبب إلزامي)
- **Fraud Detection:** أنماط مشبوهة (شراء + استرداد متكرر، حسابات متعددة)
- **Webhook Monitor:** حالة webhooks الدفع (نجاح/فشل/إعادة محاولة)

### 4.8 الميزة #7: Receipts & Invoices

**المشكلة:** لا توجد إيصالات قابلة للتنزيل بعد شراء الكريديت.

**الحل:**
- توليد PDF receipt تلقائياً بعد كل عملية شراء
- إرسال نسخة بالبريد الإلكتروني
- توفيرها في صفحة Usage History
- تضمين: التاريخ، الحزمة، المبلغ، طريقة الدفع، رقم المعاملة، الرصيد الجديد

### 4.9 الميزة #8: Credit Expiration Policy (اختياري)

| النهج | الوصف | التوصية |
|-------|-------|---------|
| **No expiry** | الكريديت لا ينتهي | ✅ موصى به (يبني الثقة) |
| **Soft expiry** | إشعار بعد 12 شهراً بدون استخدام | ⚠️ مقبول |
| **Hard expiry** | ينتهي بعد X شهراً | ❌ غير موصى به (يقلل الثقة) |

### 4.10 الميزة #9: Credit Gifting / Sharing

- إمكانية تحويل كريديت بين المستخدمين (للوكالات)
- كريديت تجريبي (trial credits) للمستخدمين الجدد
- كريديت إحالة (referral credits) عند دعوة مستخدم جديد

### 4.11 الميزة #10: Auto-Top-Up (التعبئة التلقائية)

```
┌─────────────────────────────────────────┐
│  ⚡ Auto-Top-Up Settings                │
│                                         │
│  When my balance drops to: [0] credits  │
│  Automatically buy: [3 credits ($25.99)]│
│                                         │
│  Payment method: •••• 4242              │
│                                         │
│  [Enable Auto-Top-Up]                  │
└─────────────────────────────────────────┘
```

**الفوائد:**
- ✅ يمنع انقطاع الحملات النشطة
- ✅ يزيد الإيرادات (recurring revenue simulation)
- ✅ يقلل الاحتكاك (لا حاجة للشراء اليدوي)

---

## 5. Psychology of Credits

### 5.1 تحدي "Spending Anxiety" (قلق الإنفاق)

**المشكلة:** في نظام الكريديت، كل إجراء "يكلف" شيئاً ما. هذا يخلق احتكاكاً نفسياً مستمراً — المستخدم يفكر مرتين قبل كل إجراء، مما يقلل الاستخدام ويبطئ النمو.

**الأعراض:**
- المستخدم يفتح المنصة، يرى الرصيد، ثم يغلق بدون فعل شيء
- "Hoarding" — ادخار الكريديت "لوقت لاحق" بدلاً من استخدامه
- التردد في الموافقة على الحملات ("هل المحتوى جيد بما يكفي؟")

### 5.2 استراتيجيات تقليل قلق الإنفاق

#### استراتيجية 1: "Free Preview, Paid Action" (ما تطبقه PostPilot)

```
توليد الحملة → مجاني ✅
معاينة المحتوى → مجاني ✅
الموافقة والنشر → 1 كريديت 💰
```

**لماذا يعمل:** المستخدم يرى القيمة **قبل** أن يدفع. هذا يحوّل القرار من "هل أدفع لشيء لا أعرفه؟" إلى "أنا أرى النتيجة، هل تستحق 1 كريديت؟" — قرار أسهل بكثير.

#### استراتيجية 2: "Sunk Cost Activation" (تحفيز الاستخدام)

**المبدأ:** عندما يدفع المستخدم مقابل كريديت، يصبح "مستثمراً". استخدم هذا:

| التقنية | التطبيق |
|---------|---------|
| "You have 3 unused credits" | تذكير لطيف بأن الكريديت ينتظر |
| "Your credits expire never — but your competitors don't wait" | تحفيز بلطف |
| Progress bar: "2 of 3 credits used this month" | يوضح أن الكريديت يُستخدم |
| "You've saved 15 hours using PostPilot" | يربط الكريديت بالقيمة الزمنية |

#### استراتيجية 3: "Anchoring Effect" (تأثير الإرساء)

في عرض باقات الكريديت، رتب الأسعار بحيث يبدو الخيار الأوسط هو الأفضل:

```
┌──────────┐  ┌──────────┐  ┌──────────┐
│ 1 Credit │  │ 3 Credits│  │10 Credits│
│  $9.99   │  │ $25.99   │  │ $69.99   │
│          │  │ ★ Best   │  │          │
│ $9.99/ea │  │ $8.66/ea │  │ $6.99/ea │
│          │  │  Value!  │  │          │
└──────────┘  └──────────┘  └──────────┘
```

**ما يطبقه PostPilot بالفعل:** ✅ الباقة الوسطى عليها "Most Popular" badge — ممتاز!

**تحسين مقترح:** إضافة "per credit" price تحت كل باقة لإظهار التوفير.

#### استراتيجية 4: "Loss Aversion" (النفور من الخسارة)

**المبدأ النفسي:** الناس يكرهون خسارة ما يملكونه أكثر من حبهم لكسب نفس الشيء.

**التطبيقات:**
- "You have 3 credits — don't let them go to waste!"
- "Your campaign is paused. Reactivate now (1 credit) before your audience forgets you."
- "3 credits expiring soon" (إذا كان هناك expiry — غير موصى به)

#### استراتيجية 5: "Endowment Effect" (تأثير الملكية)

اجعل المستخدم يشعر أن الكريديت "مِلكه" وأن المنصة تساعده على استخدامه:

| الرسالة | بدلاً من |
|---------|----------|
| "Your credits: 3" | "Credits remaining: 3" |
| "Spend your credits on..." | "This action costs 1 credit" |
| "You've invested in 10 credits — here's how to get the most value" | "You have 10 credits" |

### 5.3 تصميم UI لتقليل القلق

#### مبدأ "Credit Abundance" (وفرة الكريديت)

**بدلاً من:** `Credits: 1` (يبدو قليلاً)
**استخدم:** `⚡ 1 Credit Available` (يبدو كافياً)

**بدلاً من:** `Cost: 1 Credit` (يبدو مكلفاً)
**استخدم:** `Uses 1 of your 3 credits` (يبدو معقولاً)

#### مبدأ "Value Framing" (تأطير القيمة)

اربط دائماً تكلفة الكريديت بالقيمة المقدمة:

```
┌─────────────────────────────────────────┐
│  ⚡ 1 Credit = 30 days of content       │
│                                         │
│  That's:                                │
│  • 90 AI-generated posts                │
│  • 3 platforms (LinkedIn, X, Facebook) │
│  • ~15 hours of work saved              │
│  • ~$1,500 in copywriter fees saved     │
│                                         │
│  All for just 1 credit ($9.99)          │
└─────────────────────────────────────────┘
```

### 5.4 Gamification (التحفيز باللعب)

| التقنية | التطبيق | التأثير النفسي |
|---------|---------|----------------|
| **Progress streak** | "🔥 3 campaigns launched this month" | تحفيز الاستمرار |
| **Credit efficiency** | "You got 90 posts for 1 credit — 90x ROI!" | تعزيز القيمة |
| **Achievement badges** | "First Campaign", "10 Campaigns", "Power User" | مكافأة الاستخدام |
| **Monthly summary** | "This month you saved 45 hours with PostPilot" | تأكيد القيمة |
| **Usage leaderboard** | (اختياري) مقارنة مع مستخدمين آخرين | تحفيز تنافسي |

### 5.5 توصيات تصميمية محددة لـ PostPilot

1. **في wizard إنشاء الحملة (Step 4 - Review):**
   - أضف: "✨ This campaign will generate 90 AI posts across your platforms — all for 1 credit"
   - أضف: "You currently have X credits. After approval: Y credits"

2. **في صفحة الموافقة:**
   - قبل زر "Approve & Launch"، أضف value framing:
     ```
     1 Credit unlocks:
     ✅ 30 days of scheduled content
     ✅ 90 AI-crafted posts
     ✅ Auto-publishing to your channels
     ✅ ~15 hours saved
     ```

3. **في الـ dashboard:**
   - بطاقة "Your Credit ROI": "You've generated X posts and saved Y hours"
   - بطاقة "Credits at work": عرض الحملات النشطة التي تستخدم الكريديت

4. **في صفحة الفوترة:**
   - أضف "per credit" price تحت كل باقة
   - أضف "You save X%" على الباقات الأكبر
   - أضف social proof: "Join 500+ creators using PostPilot credits"

---

## 6. Final Checklist

### 🔴 Critical (يجب تطبيقه فوراً)

- [ ] **C1: Credit Pill Badge في الـ sidebar/navbar** — عرض الرصيد دائماً مع color coding ديناميكي
- [ ] **C2: Cost Preview Modal قبل "Approve & Launch"** — عرض التكلفة + الرصيد قبل/بعد + تحذير الاسترداد
- [ ] **C3: إظهار التكلفة في Step 4 (Review)** — "This action costs 1 credit" قبل التقديم
- [ ] **C4: Insufficient Credits Modal** — بدلاً من redirect، اعرض modal مع خيارات شراء داخل الصفحة
- [ ] **C5: Credit Transaction Ledger** — إنشاء جدول `credit_transactions` وتسجيل كل حركة
- [ ] **C6: Atomic refund logic** — ضمان أن الاسترداد لا يحدث مرتين (race condition protection)
- [ ] **C7: فشل التوليد = استرداد تلقائي** — إذا فشل `approve()` بعد الخصم، استرد الكريديت

### 🟡 High (يجب تطبيقه قبل الإطلاق)

- [ ] **H1: Low credit threshold alerts** — Banner عند ≤2، Toast+Email عند ≤1، Modal عند =0
- [ ] **H2: Email notifications** — شراء، استهلاك، استرداد، رصيد منخفض، رصيد صفري
- [ ] **H3: Usage/Billing History screen** — صفحة `/settings?tab=usage` مع تاريخ كامل
- [ ] **H4: Empty states احترافية** — رصيد صفري + لا حملات، رصيد صفري + محاولة إجراء
- [ ] **H5: Receipts/Invoices** — PDF قابل للتنزيل بعد كل شراء
- [ ] **H6: Value framing في صفحة الموافقة** — "1 Credit = 90 posts + 15 hours saved"
- [ ] **H7: "Per credit" price في باقات الشراء** — إظهار التوفير في الباقات الأكبر
- [ ] **H8: Admin dashboard (Filament)** — مراقبة الكريديت، تعديل يدوي، كشف احتيال

### 🟢 Medium (تحسينات ما بعد الإطلاق)

- [ ] **M1: Auto-Top-Up** — تعبئة تلقائية عند انخفاض الرصيد
- [ ] **M2: Real-time credit sync** — WebSocket/polling لتحديث الرصيد بدون reload
- [ ] **M3: Gamification** — streaks، badges، monthly ROI summary
- [ ] **M4: Credit gifting/sharing** — تحويل كريديت بين المستخدمين (للوكالات)
- [ ] **M5: Referral credits** — كريديت مجاني عند دعوة مستخدم جديد
- [ ] **M6: Trial credits** — كريديت تجريبي للمستخدمين الجدد
- [ ] **M7: Credit usage analytics** — رسوم بيانية لاستهلاك الكريديت عبر الزمن
- [ ] **M8: Webhook monitoring dashboard** — حالة webhooks الدفع في الـ admin
- [ ] **M9: Soft expiry notifications** — تذكير بعد 12 شهراً من عدم الاستخدام
- [ ] **M10: Export functionality** — CSV/PDF export لتاريخ الاستخدام

---

## 📎 الملحق: مراجع من الصناعة

| المنصة | النموذج | الدرس المستفاد |
|--------|---------|----------------|
| **Vercel** | Usage-based + credits | عرض الرصيد في navbar دائماً |
| **Replicate** | Pay-per-inference | استرداد تلقائي عند فشل API |
| **OpenAI** | API credits | Ledger تفصيلي + usage analytics |
| **Twilio** | Pre-paid credits | لا انتهاء صلاحية + receipts واضحة |
| **Midjourney** | Fast hours (credits) | Gamification (streaks, badges) |
| **HuggingFace** | Compute credits | Auto-top-up option |
| **Stability AI** | Credit packs | Anchoring effect في عرض الباقات |
| **ElevenLabs** | Subscription + credits | Hybrid model (اشتراك أساسي + كريديت إضافي) |

---

> **خلاصة:** نظام الكريديت في PostPilot مبني على أساس تقني سليم (atomic operations, race condition protection, fair-use refunds). الفجوات الرئيسية هي في **الشفافية** (الرصيد غير مرئي)، **التأكيد قبل الخصم** (لا يوجد modal)، و**التتبع** (لا يوجد ledger). تطبيق الـ Critical items في الـ checklist أعلاه سينقل المنصة من "تعمل" إلى "احترافية وموثوقة".