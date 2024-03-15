<?php

/* @var $this yii\web\View */

/* @var $form yii\bootstrap\ActiveForm */

$this->title = yii::t('app', 'Nafath App Validation');

?>

<style>
    .cycleTimerBox {
        display: inline-block;
        width: 200px;
        height: 200px;
        border-radius: 50%;
        background-color: #fff;
        float: left;
    }

    h5 {
        font-size: 20px;
    }

    #resend-code {
        color: #fff;
        background-color: #22c03c;
        display: inline-block;
        font-weight: 400;
        text-align: center;
        vertical-align: middle;
        user-select: none;
        border: 1px solid #22c03c;
        padding: 0.375rem 0.75rem;
        font-size: 0.875rem;
        line-height: 1.5;
        border-radius: 3px;
        cursor: pointer;
    }

    #resend-code {
        display: none;
    }

    .center-items{
        display: flex;
        align-content: center;
        flex-direction: column;
        align-items: center;
    }
</style>

<!-- Start Content -->
<div class="site-content pad-50" style="min-height: 400px !important;">
    <!-- Start Contact Section -->
    <section class="contact-sec">

        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="title mb-5">
                        <h4>
                            <img src="<?= Yii::$app->homeUrl ?>images/pin.png">
                            <?= yii::t('app', 'Nafath App Validation') ?>
                        </h4>
                    </div>
                    <div class="col-lg-12">

                        <div class="nafath-counter--wrap center-items">

                            <span class="cycleTimerBox">
                                <canvas height="200" width="200" id="cycleTimer"/>
                            </span>

                            <div class="center-items">
                                <a href="/web/nafath/create" id="resend-code">اعادة ارسال الكود</a>

                                <h5><strong id="nafath-text">يرجى قبول الطلب من تطبيق نفاذ وادخال الرقم اعلاه لإتمام
                                        التفعيل.</strong></h5>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>


    const IntervalTime = 60;
    const resendCode = document.getElementById('resend-code');
    const warningText = document.getElementById('nafath-text');

    let checkIfValidated = setInterval(() => {
        checkIfValidatedRequest();
    }, 5000)

    const checkIfValidatedRequest = () => {

        // Create a new XMLHttpRequest object
        const xhr = new XMLHttpRequest();

        // Configure the GET request
        // xhr.open('POST', '/nafath/check', true);

        $.get('/web/nafath/check').done(function (data){
            if (data.token === true) {
                window.location.href = '/admin'
            }
        })

        // xhr.setRequestHeader('Authorization', 'Bearer {{urldecode(request()->token)}}');
        // xhr.setRequestHeader('Access-Control-Allow-Origin', '*');

        // Set the request headers
        // xhr.setRequestHeader('Content-Type', 'application/json'); // Set appropriate content type
        // xhr.setRequestHeader('Accept', 'application/json');
        //
        // // Set up a callback function to handle the response
        // xhr.onload = function () {
        //     if (xhr.status >= 200 && xhr.status < 300) {
        //         // Request was successful, parse the response JSON
        //         var responseData = JSON.parse(xhr.responseText);
        //
        //         if (responseData.token === true) {
        //             window.location.href = '/admin'
        //         }
        //
        //     } else {
        //         // Request was not successful, handle errors
        //         console.error('Request failed with status:', xhr.status);
        //     }
        // };
        //
        // // Set up a callback function to handle network errors
        // xhr.onerror = function () {
        //     console.error('Network error occurred');
        // };
        //
        // // Send the request
        // xhr.send();
    }

    function createTimer(time) {
        var counter = document.getElementById('cycleTimer').getContext('2d');
        var no = time;
        var pointToFill = 4.72;
        var cw = counter.canvas.width;
        var ch = counter.canvas.height;
        var diff;

        function fillCounter() {
            diff = ((no / time) * Math.PI * 2 * 10);
            counter.clearRect(0, 0, cw, ch);

            // Draw the circular background
            counter.beginPath();
            counter.arc(110, 110, 70, 0, Math.PI * 2);
            counter.fillStyle = '#81ecec'; // Set the background color
            counter.fill();

            counter.lineWidth = 15;
            counter.fillStyle = '#000000';
            counter.strokeStyle = '#4ebeb2';
            counter.textAlign = 'center';
            counter.font = "75px sans-serif";
            counter.fontFamily = "Tahoma";
            counter.fontWeight = 900;
            counter.fillText(<?= $data['random'] ?>, 110, 130);
            counter.beginPath();
            counter.arc(110, 110, 70, pointToFill, diff / 10 + pointToFill);
            counter.stroke();

            if (no === 0) {
                clearTimeout(fill);
            }

            no--;
        }

        let fill = setInterval(fillCounter, 1000);
    }

    createTimer(IntervalTime);

    let generalInterval = setTimeout(() => {

        resendCode.style.display = 'block'
        warningText.innerText = 'تم انتهاء صلاحية الكود، يرجى إرساله مرة أخرى.'

        clearInterval(checkIfValidated);

    }, IntervalTime * 1000)

    const sendRequestButton = document.getElementById('resend-code');

    const sendNewRequestFunc = () => {

        resendCode.disabled = true;

        // Create a new XMLHttpRequest object
        const xhr = new XMLHttpRequest();

        // Configure the GET request
        xhr.open('POST', '/api/v1/nafath/send-request', true);

        xhr.setRequestHeader('Authorization', 'Bearer {{urldecode(request()->token)}}');
        xhr.setRequestHeader('Access-Control-Allow-Origin', '*');

        // Set the request headers
        xhr.setRequestHeader('Content-Type', 'application/json'); // Set appropriate content type
        xhr.setRequestHeader('Accept', 'application/json');

        // Set up a callback function to handle the response
        xhr.onload = function () {
            if (xhr.status >= 200 && xhr.status < 300) {

                // Request was successful, parse the response JSON
                const responseData = JSON.parse(xhr.responseText);

                // Check if responseData has a link
                if (responseData.data && responseData.data.link) {
                    // Redirect to the link provided in the response
                    window.location.href = responseData.data.link;
                }

            } else {
                // Request was not successful, handle errors
                resendCode.disabled = false
                alert('يرجى المحاولة مجددا');

                window.location.href = '/nafath/failed';

                console.error('Request failed with status:', xhr.status);
            }
        };

        // Set the request body
        const requestBody = JSON.stringify({
            national_id: ''
        });

        // Set up a callback function to handle network errors
        xhr.onerror = function () {
            console.error('Network error occurred');
        };

        // Send the request
        xhr.send(requestBody);
    }

    // sendRequestButton.addEventListener('click', sendNewRequestFunc);

</script>