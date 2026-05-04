@extends('layouts.member')
@section('title', 'Make a Payment')

@section('content')
<div class="page-header">
    <h1><i class="bi bi-credit-card me-2 text-danger"></i>Make a Payment</h1>
    <p>Pay for your membership plan below</p>
</div>

<div class="row g-4">

    {{-- ── Left: Payment form ── --}}
    <div class="col-lg-7">

        {{-- Step 1: Select membership / plan --}}
        <div class="card mb-4">
            <div class="card-header">
                <h6 class="mb-0 fw-semibold"><i class="bi bi-1-circle-fill me-2 text-danger"></i>Select Membership</h6>
            </div>
            <div class="card-body">

                {{-- Pending memberships --}}
                @if($pendingMemberships->isNotEmpty())
                <p class="small text-muted mb-3">You have pending memberships waiting for payment:</p>
                <div class="d-flex flex-column gap-2 mb-4">
                    @foreach($pendingMemberships as $ms)
                    <label class="d-flex align-items-center gap-3 p-3 rounded-3 border membership-option
                        {{ $selectedMembership?->id == $ms->id ? 'border-danger bg-danger bg-opacity-10' : '' }}"
                        style="cursor:pointer"
                        data-membership-id="{{ $ms->id }}"
                        data-plan-name="{{ $ms->plan->name }}"
                        data-plan-price="{{ $ms->plan->price }}">
                        <input type="radio" name="membership_choice" value="{{ $ms->id }}"
                            class="form-check-input mt-0"
                            {{ $selectedMembership?->id == $ms->id ? 'checked' : '' }}>
                        <div class="flex-grow-1">
                            <div class="fw-semibold small">{{ $ms->plan->name }}</div>
                            <div class="text-muted" style="font-size:.75rem">
                                {{ $ms->start_date->format('d M Y') }} — {{ $ms->end_date->format('d M Y') }}
                                &nbsp;·&nbsp; {{ $ms->plan->duration_months }} month{{ $ms->plan->duration_months > 1 ? 's' : '' }}
                            </div>
                        </div>
                        <div class="fw-bold text-danger">{{ $ms->plan->formatted_price }}</div>
                    </label>
                    @endforeach
                </div>
                <hr class="my-3">
                <p class="small text-muted mb-2">Or subscribe to a different plan:</p>
                @else
                <p class="small text-muted mb-3">Choose a membership plan to subscribe to:</p>
                @endif

                {{-- Available plans --}}
                <div class="row g-3">
                    @foreach($plans as $plan)
                    <div class="col-sm-6">
                        <div class="card h-100 border plan-card"
                             style="cursor:pointer"
                             data-plan-id="{{ $plan->id }}"
                             data-plan-name="{{ $plan->name }}"
                             data-plan-price="{{ $plan->price }}">
                            <div class="card-body p-3">
                                <div class="fw-semibold small mb-1">{{ $plan->name }}</div>
                                <div class="text-danger fw-bold">{{ $plan->formatted_price }}</div>
                                <div class="text-muted" style="font-size:.72rem">/ {{ $plan->duration_months }} month{{ $plan->duration_months > 1 ? 's' : '' }}</div>
                                <ul class="list-unstyled mt-2 mb-0" style="font-size:.75rem">
                                    <li><i class="bi bi-check-circle-fill text-success me-1"></i>
                                        {{ $plan->max_classes == 0 ? 'Unlimited classes' : $plan->max_classes . ' classes/month' }}
                                    </li>
                                    <li>
                                        <i class="bi bi-{{ $plan->personal_trainer ? 'check-circle-fill text-success' : 'x-circle-fill text-muted' }} me-1"></i>
                                        Personal Trainer
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Step 2: Payment method --}}
        <div class="card mb-4" id="paymentMethodCard">
            <div class="card-header">
                <h6 class="mb-0 fw-semibold"><i class="bi bi-2-circle-fill me-2 text-danger"></i>Payment Method</h6>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    @foreach([
                        'credit_card'   => ['icon' => 'credit-card-2-front', 'label' => 'Credit Card'],
                        'debit_card'    => ['icon' => 'credit-card',          'label' => 'Debit Card'],
                        'bank_transfer' => ['icon' => 'bank',                 'label' => 'Bank Transfer'],
                        'e_wallet'      => ['icon' => 'phone',                'label' => 'E-Wallet'],
                        'cash'          => ['icon' => 'cash-coin',            'label' => 'Cash'],
                    ] as $value => $info)
                    <div class="col-6 col-md-4">
                        <label class="d-flex flex-column align-items-center justify-content-center gap-2 p-3 rounded-3 border method-option"
                               style="cursor:pointer;min-height:90px;transition:all .2s"
                               data-value="{{ $value }}">
                            <input type="radio" name="payment_method_choice" value="{{ $value }}" class="d-none">
                            <i class="bi bi-{{ $info['icon'] }} fs-4 text-muted method-icon"></i>
                            <span class="small fw-semibold text-muted method-label">{{ $info['label'] }}</span>
                        </label>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Hidden forms --}}

        {{-- Form A: pay existing pending membership --}}
        <form method="POST" action="{{ route('member.payment.process') }}" id="payExistingForm" class="d-none">
            @csrf
            <input type="hidden" name="membership_id" id="existingMembershipId"
                   value="{{ $selectedMembership?->id }}">
            <input type="hidden" name="payment_method" id="existingPaymentMethod">
        </form>

        {{-- Form B: subscribe to new plan --}}
        <form method="POST" action="{{ route('member.payment.subscribe') }}" id="subscribeForm" class="d-none">
            @csrf
            <input type="hidden" name="plan_id" id="newPlanId">
            <input type="hidden" name="payment_method" id="newPlanMethod">
        </form>

        {{-- Confirm button --}}
        <button type="button" class="btn btn-primary w-100 py-3 fw-semibold" id="confirmBtn" disabled
                onclick="submitPayment()">
            <i class="bi bi-lock-fill me-2"></i>Confirm & Pay
        </button>
        <p class="text-center text-muted small mt-2">
            <i class="bi bi-shield-check me-1"></i>Your payment is processed securely.
        </p>
    </div>

    {{-- ── Right: Order summary ── --}}
    <div class="col-lg-5">
        <div class="card sticky-top" style="top:80px">
            <div class="card-header">
                <h6 class="mb-0 fw-semibold"><i class="bi bi-receipt me-2 text-danger"></i>Order Summary</h6>
            </div>
            <div class="card-body" id="orderSummary">
                <div class="text-center text-muted py-4 small" id="summaryEmpty">
                    <i class="bi bi-bag fs-2 d-block mb-2 opacity-25"></i>
                    Select a plan to see your order summary
                </div>
                <div id="summaryContent" class="d-none">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="small text-muted">Plan</span>
                        <span class="small fw-semibold" id="summaryPlanName">—</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="small text-muted">Method</span>
                        <span class="small fw-semibold" id="summaryMethod">—</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between">
                        <span class="fw-bold">Total</span>
                        <span class="fw-bold text-danger fs-5" id="summaryAmount">—</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Back link --}}
        <a href="{{ route('member.payments') }}" class="btn btn-outline-secondary w-100 mt-3">
            <i class="bi bi-arrow-left me-2"></i>Back to Payment History
        </a>
    </div>

</div>
@endsection

@push('scripts')
<script>
    // ── State ──────────────────────────────────────────────────────────────
    let selectedMembershipId = {{ $selectedMembership ? $selectedMembership->id : 'null' }};
    let selectedPlanId       = null;
    let selectedMethod       = null;
    let isNewPlan            = false;

    // ── Pre-select pending membership if available ─────────────────────────
    @if($selectedMembership)
    updateSummaryPlan(
        '{{ addslashes($selectedMembership->plan->name) }}',
        {{ $selectedMembership->plan->price }}
    );
    checkConfirmReady();
    @endif

    // ── Pending membership selection ───────────────────────────────────────
    document.querySelectorAll('.membership-option').forEach(function (el) {
        el.addEventListener('click', function () {
            var id     = this.dataset.membershipId;
            var name   = this.dataset.planName;
            var amount = this.dataset.planPrice;

            selectedMembershipId = id;
            selectedPlanId       = null;
            isNewPlan            = false;

            // Highlight selected, clear others
            document.querySelectorAll('.membership-option').forEach(function (o) {
                o.classList.remove('border-danger', 'bg-danger', 'bg-opacity-10');
            });
            this.classList.add('border-danger', 'bg-danger', 'bg-opacity-10');

            // Check the radio inside
            var radio = this.querySelector('input[type=radio]');
            if (radio) radio.checked = true;

            // Clear plan card highlights
            document.querySelectorAll('.plan-card').forEach(function (c) {
                c.classList.remove('border-danger');
                c.style.background = '';
            });

            updateSummaryPlan(name, amount);
            checkConfirmReady();
        });
    });

    // ── New plan card selection ────────────────────────────────────────────
    document.querySelectorAll('.plan-card').forEach(function (el) {
        el.addEventListener('click', function () {
            var id     = this.dataset.planId;
            var name   = this.dataset.planName;
            var amount = this.dataset.planPrice;

            selectedPlanId       = id;
            selectedMembershipId = null;
            isNewPlan            = true;

            // Highlight selected plan card, clear others
            document.querySelectorAll('.plan-card').forEach(function (c) {
                c.classList.remove('border-danger');
                c.style.background = '';
            });
            this.classList.add('border-danger');
            this.style.background = 'rgba(230,57,70,.05)';

            // Uncheck pending membership radios
            document.querySelectorAll('.membership-option').forEach(function (o) {
                o.classList.remove('border-danger', 'bg-danger', 'bg-opacity-10');
                var radio = o.querySelector('input[type=radio]');
                if (radio) radio.checked = false;
            });

            updateSummaryPlan(name, amount);
            checkConfirmReady();
        });
    });

    // ── Payment method selection ───────────────────────────────────────────
    document.querySelectorAll('.method-option').forEach(function (el) {
        el.addEventListener('click', function () {
            // Reset all
            document.querySelectorAll('.method-option').forEach(function (o) {
                o.style.background  = '';
                o.style.borderColor = '';
                o.querySelector('.method-icon').classList.remove('text-danger');
                o.querySelector('.method-icon').classList.add('text-muted');
                o.querySelector('.method-label').classList.remove('text-danger');
                o.querySelector('.method-label').classList.add('text-muted');
            });

            // Highlight clicked
            this.style.background  = 'rgba(230,57,70,.08)';
            this.style.borderColor = '#e63946';
            this.querySelector('.method-icon').classList.remove('text-muted');
            this.querySelector('.method-icon').classList.add('text-danger');
            this.querySelector('.method-label').classList.remove('text-muted');
            this.querySelector('.method-label').classList.add('text-danger');
            this.querySelector('input[type=radio]').checked = true;

            selectedMethod = this.dataset.value;

            var labels = {
                credit_card: 'Credit Card', debit_card: 'Debit Card',
                bank_transfer: 'Bank Transfer', e_wallet: 'E-Wallet', cash: 'Cash'
            };
            document.getElementById('summaryMethod').textContent = labels[selectedMethod] || selectedMethod;

            checkConfirmReady();
        });
    });

    // ── Helpers ────────────────────────────────────────────────────────────
    function updateSummaryPlan(name, amount) {
        document.getElementById('summaryEmpty').classList.add('d-none');
        document.getElementById('summaryContent').classList.remove('d-none');
        document.getElementById('summaryPlanName').textContent = name;
        document.getElementById('summaryAmount').textContent   =
            'Rp ' + new Intl.NumberFormat('id-ID').format(amount);
    }

    function checkConfirmReady() {
        var ready = selectedMethod && (selectedMembershipId || selectedPlanId);
        document.getElementById('confirmBtn').disabled = !ready;
    }

    function submitPayment() {
        if (!selectedMethod) return;

        if (isNewPlan && selectedPlanId) {
            // Store method in a hidden field so it survives the subscribe redirect
            document.getElementById('newPlanId').value            = selectedPlanId;
            document.getElementById('newPlanMethod').value        = selectedMethod;
            document.getElementById('subscribeForm').submit();
        } else if (selectedMembershipId) {
            document.getElementById('existingMembershipId').value  = selectedMembershipId;
            document.getElementById('existingPaymentMethod').value = selectedMethod;
            document.getElementById('payExistingForm').submit();
        }
    }
</script>
@endpush
