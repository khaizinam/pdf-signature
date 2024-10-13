
<header>
    <div class="content-header container-content">
        <span class="contract-title">{{ $contract->name ?? '' }}</span>
        <span class="contract-date">{{ $contract->created_at ?? '' }}</span>
    </div>
</header>
<div class="container-content contract-wrapper sig-wrap" style="display:flex;justify-content:space-beweent;">

    <div class="left-content pdf-file" id="pdf-wrapper">
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
            <button class="d-flex flex-column justify-content-center align-items-center" id="save-pdf-2">
                <i class="fa-solid fa-file-export"></i>
                <span>Tải</span>
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
                    <img id="loaded-signature" src="" alt="Loaded Signature" style="display:none;width:120px;height:120px;" />
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
                    <span>Ký</span>
                </button>

                <img id="loaded-signature" style="display: none;" />
            </div>

            <!-- Modal -->
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
<input type="hidden" name="contract-id" id="contract-id" value="{{ Arr::get($contract, 'id', '')}}">

