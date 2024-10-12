<header>
    <div class="content-header container-content">
        <span class="contract-title">{{ $contract->name ?? '' }}</span>
        <span class="contract-date">{{ $contract->created_at ?? '' }}</span>
    </div>
</header>
<div class="container-content contract-wrapper" style="display:flex;justify-content:space-beweent;">
    <div class="left-content pdf-file">
        {{-- <div class="canva-draw"> --}}
        <canvas id="pdf-canvas" width="800" height="1200" ondrop="drop(event)" ondragover="allowDrop(event)"
            ondragleave="removeDropEffect(event)"></canvas>
        {{-- </div> --}}
    </div>
    <div class="right-content canvas-file">
        <div id="signature-pad" class="signature-pad">
            <div id="canvas-wrapper" class="signature-pad--body">
                <canvas width="600" style="touch-action: none; user-select: none;" height="600"></canvas>
            </div>
            <div class="signature-pad--footer">
                <div class="description">
                    Ký ở trên
                </div>
                <img id="loaded-signature" src="" alt="Loaded Signature" style="display:none;" />
                <div class="signature-pad--actions container">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="row container">
                                <button type="button" class="button clear btn btn-primary" data-action="clear">
                                    Xoá
                                </button>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="row container">
                                <button type="button" class="button save btn btn-primary" data-action="save-png">
                                    Tải xuống
                                </button>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="row">
                                <button type="button" class="button save btn btn-primary" id="save-signature">Lưu tạm
                                    chữ ký</button>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="row">
                                <button type="button" class="button load btn btn-primary" id="load-signature">Tải chữ
                                    ký đã lưu</button>
                                <button type="button" class="button load btn btn-primary" id="prev-page">Trang trước</button>
                                <button type="button" class="button load btn btn-primary" id="next-page">Trang sau</button>
                            </div>
                        </div>

                        <input type="file" id="upload-signature" accept="image/*">
                    </div>
                    <div class="row mb-3">
                        <div class="input-group mb-3 col-md-12">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">Nhập tên</span>
                            </div>
                            <input type="text" class="form-control" placeholder="Họ và tên" aria-label="Username"
                                aria-describedby="basic-addon1">
                        </div>
                    </div>
                    <div class="row">
                        <button id="save-pdf" class="btn btn-primary">
                            Lưu PDF với chữ ký
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<input type="hidden" name="url-pdf" id="pdf-url" value="{{ get_object_image(Arr::get($contract, 'file', '')) }}">
