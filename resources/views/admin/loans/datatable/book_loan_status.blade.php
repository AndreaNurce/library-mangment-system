@if($book_loan_status === \App\Enums\LoanRequestStatusEnum::APPROVED)
    <span class="badge badge-primary">Aprovuar</span>
@elseif($book_loan_status === \App\Enums\LoanRequestStatusEnum::PENDING)
    <span class="badge badge-warning">Ne Pritje</span>
@elseif($book_loan_status === \App\Enums\LoanRequestStatusEnum::REJECTED)
    <span class="badge badge-danger">Refuzuar</span>
@else
    <span class="badge badge-secondary">----</span>
@endif
