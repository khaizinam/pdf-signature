<div class="content" style="display:flex;justify-content:space-beweent;">
    <div class="pdf-file">
        <input type="file" id="upload-pdf" accept="application/pdf">
        <input type="file" id="upload-signature" accept="image/*">

        <!-- Canvas to show PDF page -->
        <canvas id="pdf-canvas" width="500" height="700"></canvas>

        <!-- Save PDF button -->
        <div id="controls">
        <button id="save-pdf">Lưu PDF với chữ ký</button>
        </div>
    </div>
    <div class="canvas-file">
        <div id="signature-pad" class="signature-pad">
            <div id="canvas-wrapper" class="signature-pad--body">
                <canvas width="660" style="touch-action: none; user-select: none;" height="200"></canvas>
            </div>
            <div class="signature-pad--footer">
                <div class="description">Sign above</div>

                <div class="signature-pad--actions">
                <div class="column">
                    <button type="button" class="button clear" data-action="clear">Clear</button>
                    <button type="button" class="button" data-action="undo" title="Ctrl-Z">Undo</button>
                    <button type="button" class="button" data-action="redo" title="Ctrl-Y">Redo</button>
                    <br/>
                    <button type="button" class="button" data-action="change-color">Change color</button>
                    <button type="button" class="button" data-action="change-width">Change width</button>
                    <button type="button" class="button" data-action="change-background-color">Change background color</button>

                </div>
                <div class="column">
                    <button type="button" class="button save" data-action="save-png">Save as PNG</button>
                    <button type="button" class="button save" data-action="save-jpg">Save as JPG</button>
                    <button type="button" class="button save" data-action="save-svg">Save as SVG</button>
                    <button type="button" class="button save" data-action="save-svg-with-background">Save as SVG with
                    background</button>
                </div>
                </div>

                <div>
                <button type="button" class="button" data-action="open-in-window">Open in Window</button>
                </div>
                <button type="button" class="button save" data-action="save-localstorage">Save to LocalStorage</button>
    <button type="button" class="button load" data-action="load-localstorage">Load from LocalStorage</button>
            </div>
            </div>
        </div>
</div>

