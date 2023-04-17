@if($role == \App\Enums\UserRoleEnum::ADMIN)
    <span class="badge badge-primary">Admin</span>
@else
    <span class="badge badge-secondary">User</span>
@endif
