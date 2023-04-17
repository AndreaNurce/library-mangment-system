<a href="{{ route('admin.loans.show', ['loan' => $id]) }}" class="btn btn-outline-info btn-sm" title="View">
    <i class="fa fa-eye"></i>
</a>
<a href="{{ route('admin.loans.edit', ['loan' => $id]) }}" class="btn btn-outline-warning btn-sm" title="Edit">
    <i class="fa fa-pen"></i>
</a>

<a href="javascript:void(0);" class="btn btn-outline-danger btn-sm action-button" title="Delete"
   data-action="{{ route('admin.loans.destroy', ['loan' => $id]) }}"
   data-method="DELETE"
   data-title="Fshije Huazimin"
   data-message="Jeni te sigurt qe doni te fshini kete huazim!?"
   data-is-danger="true"
>
    <i class="fa fa-trash"></i>
</a>

