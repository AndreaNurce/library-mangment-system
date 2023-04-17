<div id="action-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-danger" id="action-title"></h5>
            </div>
            <div class="modal-body">
                <p id="action-message"></p>
            </div>
            <div id="action-form-inputs"></div>
            <div class="modal-footer">
                <form action="javascript:void(0);" id="action-form-modal" method="POST">
                    @csrf
                    @method('DELETE')
                    <div id="action-form-inputs"></div>
                    <button type="button" class="btn btn-light waves-effect" data-dismiss="modal">Cancel</button>
                    <button type="submit" id="action-form-button" class="btn btn-danger waves-effect waves-light">Proceed</button>
                </form>
            </div>
        </div>
    </div>
</div>
