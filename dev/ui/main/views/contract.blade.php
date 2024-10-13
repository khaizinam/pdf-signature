
<header>
    <div class="content-header container-content">
        <span class="contract-title">{{ $contract->name ?? '' }}</span>
        <span class="contract-date">{{ $contract->created_at ?? '' }}</span>
    </div>
</header>
<div class="container-content contract-wrapper sig-wrap" style="display:flex;justify-content:space-beweent;">

    <div class="left-content pdf-file">
        {{-- <div class="canva-draw"> --}}
        <canvas id="pdf-canvas" width="800" height="1200" ondrop="drop(event)" ondragover="allowDrop(event)"
            ondragleave="removeDropEffect(event)"></canvas>
        {{-- </div> --}}
    </div>

    <div class="right-content canvas-file" id="menu-bar">
        <div class="menu-bar-side">
            <button class="ajax-open-menu">
                <i class="fa-solid fa-bars"></i>
            </button>
            <button class="" id="prev-page">
                <i class="fa-solid fa-backward"></i>
                <span>Trước</span>
            </button>
            <button class="" id="next-page">
                <i class="fa-solid fa-forward"></i>
                <span>Sau</span>
            </button>
            <button class="">
                <span id="current-page">0</span>
                <span>/</span>
                <span id="total-page">8</span>
            </button>
        </div>
        <div id="signature-pad" class="signature-pad">
            <!-- Button trigger modal -->
            <div class="signature-pad-area">
                <div id="canvas-wrapper" class="signature-pad--body">
                    <canvas width="660" style="touch-action: none; user-select: none;"
                        height="200"></canvas>
                </div>
                <div class="signature-pad--footer">
                    <div class="description">
                        Ký ở trên
                    </div>
                    <img id="loaded-signature" src="" alt="Loaded Signature" style="display:none;max-width:100px;" />
                </div>
            </div>
            <div class="button-mode-group">
                <button type="button" class="custom-button clear" data-action="clear">
                    <i class="fa-solid fa-trash"></i>
                    <span>Xoá</span>
                </button>
                <button type="button" class="custom-button save" data-action="save-png">
                    <i class="fa-solid fa-download"></i>
                    <span>Tải</span>
                </button>
                <button type="button" class="custom-button save" id="save-signature">
                    <i class="fa-solid fa-floppy-disk"></i>
                    <span>Lưu</span>
                </button>
                <button type="button" class="custom-button load" id="load-signature">
                    <i class="fa-solid fa-upload"></i>
                    <span>Ký</span>
                </button>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <svg width="30" height="30" viewBox="0 0 39 39" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <rect x="0.5" y="0.5" width="38" height="38" rx="19"
                                        fill="white"></rect>
                                    <rect x="0.5" y="0.5" width="38" height="38" rx="19"
                                        stroke="#FFB700"></rect>
                                    <path
                                        d="M24.96 15.1398L23.8602 14.04L19.5 18.4002L15.1398 14.04L14.04 15.1398L18.4002 19.5L14.04 23.8602L15.1398 24.96L19.5 20.5998L23.8602 24.96L24.96 23.8602L20.5998 19.5L24.96 15.1398Z"
                                        fill="#FFB700"></path>
                                </svg>
                            </button>
                        </div>

                    </div>
                </div>
            </div>
            <div class="signature-pad--actions container">
                <div class="row mb-3">
                    <div class="input-group mb-3 col-md-12">
                        <input type="text" class="form-control" placeholder="Họ và tên" aria-label="Username"
                            aria-describedby="basic-addon1">
                    </div>
                </div>
                <div class="row">
                    <button id="save-pdf" class="sig-btn">
                        <div class="pdf-icon">
                            PDF
                        </div>
                        Lưu PDF với chữ ký
                    </button>
                </div>
            </div>
            </div>
        </div>
    </div>


</div>
<input type="hidden" name="url-pdf" id="pdf-url" value="{{ get_object_image(Arr::get($contract, 'file', '')) }}">

