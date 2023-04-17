@if($status === \App\Enums\StatusEnum::ACTIVE)
    <span class="badge badge-primary">Active</span>
@elseif($status === \App\Enums\StatusEnum::BANNED)
    <span class="badge badge-warning">Banned</span>
@elseif($status === \App\Enums\StatusEnum::INACTIVE)
    <span class="badge badge-secondary">Inactive</span>
@else
    <span class="badge badge-warning">Suspended</span>
@endif
