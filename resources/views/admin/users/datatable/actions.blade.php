<a href="{{ route('admin.users.show', ['user' => $id]) }}" class="btn btn-outline-info btn-sm" title="View">
    <i class="fa fa-eye"></i>
</a>
<a href="{{ route('admin.users.edit', ['user' => $id]) }}" class="btn btn-outline-warning btn-sm" title="Edit">
    <i class="fa fa-pen"></i>
</a>

<a href="javascript:void(0);" class="btn btn-outline-danger btn-sm action-button" title="Delete"
   data-action="{{ route('admin.users.destroy', ['user' => $id]) }}"
   data-method="DELETE"
   data-title="Delete User"
   data-message="Are you sure you want to delete this User!?"
   data-is-danger="true"
>
    <i class="fa fa-trash"></i>
</a>

