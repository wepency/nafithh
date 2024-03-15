$(document).ready(function () {

// function downloadPdf(){};
    if ($('#divIdToPrint').length) {

        // console.log(downloadPdf());
        var imgData;
        $.getScript("https://unpkg.com/html2canvas@1.0.0-rc.5/dist/html2canvas.js", function (data, textStatus, jqxhr) {
            html2canvas(document.getElementById('divIdToPrint'),
                {
                    allowTaint: true,
                    useCORS: true,
                    letterRendering: true,
                    // windowWidth: '1480px',
                    // width: '1220',
                    // x:15,
                    // y:114,
                    // scrollX: -window.scrollX,
                    // scrollY: -window.scrollY,
                    // windowWidth: '1492',
                    // windowWidth: '1492px',
                    // windowHeight: document.documentElement.offsetHeight,
                    // // dpi: 300,
                    // width: '1492',
                    // height: 800,
                    scale: 1.3
                }).then((canvas) => {
                imgData = canvas.toDataURL('image/png');
            });
        });

        $('#down-jpg').click(function () {
            const a = document.createElement('a')
            a.setAttribute('download', 'image.png')
            a.setAttribute('href', imgData)
            a.click();
        });
    }

    downloadPdf = function (id, csrf) {
        // var file= dataURLtoBlob(imgData);
        ajaxPostDownload("download/" + id + "?type=pdf", {"_csrf-backend": csrf, "image": imgData})
        // ajaxPostDownload("download/<?=$contract->id?>?type=pdf",{"_csrf-backend": "<?=Yii::$app->request->csrfToken?>","image": file})
    };


    function ajaxPostDownload(url, data, form) {
        var $form;
        if (($form = $('#download_form')).length === 0) {
            $form = $("<form id='download_form'" + " style='display: none; width: 1px; height: 1px; position: absolute; top: -10000px' method='POST' action='" + url + "'></form>");
        }
        //Clear the form fields
        $form.appendTo("body");
        $form.html("");
        //Create new form fields
        Object.keys(data).forEach(function (key) {
            $form.append("<input type='hidden' name='" + key + "' value='" + data[key] + "'>");
        });
        //Submit the form post
        $form.submit();
    }
});

function disableButton(btn) {
    btn.attr('disabled', true).addClass('loading').append('<span class="loading-wrap""><svg class="spinner" fill="#333" viewBox="0 0 50 50"><circle class="path" cx="25" cy="25" r="20" fill="none" stroke-width="5"></circle></svg></span>')
}

function enableButton(btn) {
    btn.attr('disabled', false).removeClass('loading').find('span').remove();
}