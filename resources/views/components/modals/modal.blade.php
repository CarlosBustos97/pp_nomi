<div class="modal inmodal" id="{{ $modal_id }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog {{ isset($modal_size) ? $modal_size : '' }}">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <div class="form-group row">
                    {{ isset($modal_header) ? $modal_header : '' }}
                    <div class="col-md-8">
                        <h3 class="text-left">{{ isset($modal_title) ? $modal_title : '' }}</h3>
                    </div>
                    <div class="col-md-4">
                        @if ( isset($btn_close) ? $btn_close : false )
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        @endif
                    </div>
                </div>
            </div>
            <div class="modal-body">
                {{ isset($modal_body) ? $modal_body : '' }}
            </div>
            {{ isset($modal_extra) ? $modal_extra : '' }}
            <div class="modal-footer">
                {{ isset($modal_footer) ? $modal_footer : '' }}
                @if ( isset($buttons) ? $buttons : false )
                    <a href="#" class="btn btn-secondary btn-icon-split", data-dismiss="modal">
                        <span class="text">Cerrar</span>
                    </a>
                    <a href="#" class="btn btn-info btn-icon-split", id="{{ $btn_modal_id }}">
                        <span class="text">{{ $ppal_btn_text }}</span>
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>
