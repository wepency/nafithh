<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Ad */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Ads'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<style>
    body, html {
        direction: rtl;
        padding: 0 !important;
        margin: 0;
        background: #fff;
        color: #263238;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
        overflow-x: hidden;
        text-align: flex-start;
        height: 100%;
        position: relative;
        z-index: 1
    }

    body:before {
        width: 400px;
        background: url(/_next/static/media/bg-top.a0e04b74.svg);
        background-repeat: no-repeat;
        background-size: contain;
        right: -138px;
        top: 70px
    }

    body:after, body:before {
        content: "";
        height: 400px;
        display: block;
        position: absolute;
        z-index: 0
    }

    body:after {
        width: 700px;
        background: url(/_next/static/media/bg-left.c74b735c.svg);
        background-repeat: no-repeat;
        background-size: contain;
        left: 0;
        top: 160px
    }

    ul {
        padding: 0;
        margin: 0 !important;
        list-style-type: none
    }

    .container {
        max-width: 1140px;
        padding-right: 15px;
        padding-left: 15px;
        margin-right: auto;
        margin-left: auto;
        position: relative;
        z-index: 1
    }

    .container.auth {
        padding: 30px
    }

    a {
        text-decoration: none;
        transition: all .5s;
        color: inherit
    }

    .grecaptcha-badge {
        visibility: hidden
    }

    input::-webkit-inner-spin-button, input::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0
    }

    input[type=number] {
        -moz-appearance: textfield
    }

    h1, h2, h3, h4, h5, h6 {
        font-family: "29LT Bukra"
    }

    .input-group {
        margin-bottom: 20px;
        position: relative;
        padding-bottom: 20px
    }

    .input-group label {
        display: flex;
        color: #101728;
        font-size: 12px;
        font-weight: 500;
        margin-bottom: 8px
    }

    .input-group label .required-star {
        color: #b72626;
        -webkit-margin-start: 5px;
        margin-inline-start: 5px
    }

    .input-group label.label-optional {
        display: flex;
        justify-content: space-between
    }

    .input-group label.label-optional span {
        color: #909a9f;
        font-size: 12px
    }

    .input-group input, .input-group textarea {
        width: calc(100% - 42px);
        height: 46px;
        font-family: "29LT Bukra";
        border: 2px solid #909a9f;
        border-radius: 6px;
        padding: 0 20px;
        color: #000;
        font-weight: 700;
        font-size: 12px;
        transition: all .5s
    }

    .input-group input:focus, .input-group input:hover, .input-group textarea:focus, .input-group textarea:hover {
        border: 2px solid #101728
    }

    .input-group textarea {
        height: 100px;
        padding: 20px
    }

    .input-group.inputError {
        position: relative
    }

    .input-group.inputError input {
        border: 2px solid #b72626
    }

    .input-group.inputError input:focus, .input-group.inputError input:focus-visible, .input-group.inputError input:hover {
        border: 2px solid #b72626 !important
    }

    .input-group.inputError .icon-msg-error {
        display: block;
        position: absolute;
        left: 11px;
        top: 40px
    }

    .input-group.inputError .icon-msg-error svg {
        color: #909a9f
    }

    .input-group.inputError .noteMsg {
        display: block;
        color: #b72626;
        font-size: 10px;
        margin-top: 10px;
        position: absolute
    }

    .input-group.inputError .DatePickerInput .MuiOutlinedInput-notchedOutline {
        border: 2px solid #b72626 !important
    }

    .input-group.inputError .DatePickerInput input:focus, .input-group.inputError .DatePickerInput input:focus-visible, .input-group.inputError .DatePickerInput input:hover {
        border: 0 !important
    }

    .input-group .form-select {
        font-family: "29LT Bukra";
        border: 2px solid #909a9f;
        border-radius: 6px;
        height: 50px;
        font-weight: 700;
        font-size: 14px;
        color: #909a9f;
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        background-image: url(/_next/static/media/arrow-down.421a1d07.svg);
        background-repeat: no-repeat;
        background-position: left 10px center;
        background-size: 16px 12px;
        padding: 0 10px
    }

    .icon-msg-error, .noteMsg {
        display: none
    }

    .nhc-btn {
        height: 50px;
        font-weight: 500;
        font-family: "29LT Bukra";
        padding: 0 20px;
        background: transparent;
        border-radius: 6px;
        border: 2px solid transparent;
        display: flex;
        justify-content: center;
        align-items: center;
        transition: all .3s;
        cursor: pointer
    }

    .nhc-btn.nhc-btn-link {
        color: #004f83;
        border: 2px solid transparent
    }

    .nhc-btn.nhc-btn-link:hover {
        color: #006fb7;
        border: 2px solid transparent
    }

    .nhc-btn img, .nhc-btn svg {
        -webkit-margin-start: 5px;
        margin-inline-start: 5px
    }

    .nhc-btn.btn-primery-solid {
        color: #006fb7;
        border-color: #006fb7
    }

    .nhc-btn.btn-primery-solid:hover .nhc-btn.btn-primery-solid.active-btn {
        color: #004f83;
        border-color: #004f83;
        box-shadow: 0 3px 6px rgba(0, 0, 0, .08)
    }

    .nhc-btn.btn-full-icon {
        width: 100%;
        background: #006fb7;
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 3px 6px rgba(0, 0, 0, .08)
    }

    .nhc-btn.btn-full-icon img, .nhc-btn.btn-full-icon svg {
        filter: brightness(0) invert(1)
    }

    .nhc-btn.btn-full-icon:hover {
        background: #004f83
    }

    .nhc-btn.btn-full-icon.coustom-szie {
        width: 220px
    }

    .nhc-btn.btn-full-icon-outline {
        background: #fff;
        color: #006fb7;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 3px 6px rgba(0, 0, 0, .08);
        border: 2px solid #006fb7;
        padding: 0 20px;
        margin: 30px auto 0
    }

    .nhc-btn.btn-full-icon-outline:hover {
        background: #fff;
        border: 2px solid #004f83;
        color: #004f83
    }

    .nhc-btn.btn-full-icon-outline img, .nhc-btn.btn-full-icon-outline svg {
        -webkit-margin-start: 5px;
        margin-inline-start: 5px;
        filter: none
    }

    .nhc-btn.btn-full-icon-outline.btn-full-icon-outline-inner {
        margin: 0
    }

    .nhc-btn.btn-full-noBackground {
        color: #006fb7
    }

    .nhc-btn.btn-full-noBackground:hover {
        color: #004f83
    }

    .nhc-btn.btn-gray {
        border: 2px solid #4d5a61;
        color: #4d5a61
    }

    .nhc-btn.btn-gray svg {
        -webkit-margin-end: 5px;
        margin-inline-end: 5px
    }

    .nhc-btn.btn-gray:hover {
        border: 2px solid #909a9f;
        color: #909a9f
    }

    .nhc-btn.btn-remove {
        border: 2px solid #b72626;
        color: #b72626
    }

    .nhc-btn.btn-remove svg {
        -webkit-margin-end: 5px;
        margin-inline-end: 5px;
        -webkit-margin-start: 0;
        margin-inline-start: 0
    }

    .nhc-btn.btn-remove:hover {
        border: 2px solid #b72626;
        color: #b72626;
        opacity: .8
    }

    .nhc-btn-to-home {
        margin: 0 auto;
        cursor: pointer
    }

    .IconInner svg {
        -webkit-margin-end: 5px;
        margin-inline-end: 5px;
        -webkit-margin-start: 0;
        margin-inline-start: 0
    }

    .btn-prPassword {
        width: 450px
    }

    .wd-100 {
        width: 100% !important
    }

    .wd-70 {
        width: 70% !important
    }

    .wd-270 {
        width: 270px !important
    }

    .wd-235 {
        width: 235px !important
    }

    .wd-auto {
        width: auto !important
    }

    .input-group-block {
        display: flex
    }

    .m0 {
        margin: 0 !important
    }

    .block-date-group {
        position: relative
    }

    .block-date-group .select-date {
        width: 230px;
        -webkit-margin-end: 15px;
        margin-inline-end: 15px
    }

    .block-date-group .icon-date {
        position: absolute;
        left: 10px;
        top: 14px;
        color: #909a9f
    }

    .add-new-adv {
        font-weight: 500;
        width: 235px
    }

    .block-from-group {
        display: flex;
        flex-wrap: wrap;
        align-items: center
    }

    .block-from-group .form-select {
        width: 100%
    }

    .block-from-group.one-col .input-group {
        width: calc(50% - 5px);
        -webkit-margin-end: 5px;
        margin-inline-end: 5px
    }

    .block-from-group.two-col .input-group {
        width: calc(50% - 15px);
        -webkit-margin-end: 15px;
        margin-inline-end: 15px
    }

    .block-from-group.three-col .input-group {
        width: calc(33.3% - 15px);
        -webkit-margin-end: 15px;
        margin-inline-end: 15px
    }

    .block-from-group.four-col .input-group {
        width: calc(25% - 15px);
        -webkit-margin-end: 15px;
        margin-inline-end: 15px
    }

    .block-from-group.five-col .input-group {
        width: calc(6% - 15px);
        -webkit-margin-end: 6px;
        margin-inline-end: 6px
    }

    .block-from-group .fld-password {
        position: relative
    }

    .block-from-group .fld-password svg {
        position: absolute;
        left: 10px;
        top: 40px;
        color: #909a9f;
        font-size: 18px
    }

    .block-from-group .form-check {
        display: flex;
        align-items: center
    }

    .block-from-group .form-check span {
        color: #8fceca
    }

    .block-from-group .form-check label {
        display: flex
    }

    .block-from-group .form-check button {
        padding: 0;
        -webkit-margin-start: 5px;
        margin-inline-start: 5px
    }

    .block-from-group .form-check button:focus, .block-from-group .form-check button:hover {
        background: transparent !important
    }

    .checkbock .MuiFormControlLabel-label {
        font-family: "29LT Bukra";
        font-weight: 500
    }

    .btn-disabled, button[disabled], input[disabled] {
        background: #edeff0 !important;
        color: #909a9f !important;
        box-shadow: none !important;
        cursor: not-allowed
    }

    .btn-disabled svg, button[disabled] svg, input[disabled] svg {
        color: #909a9f !important;
        filter: none !important
    }

    .MuiInputBase-root {
        background: #fff !important;
        border-radius: 6px !important
    }

    .MuiInputBase-root .MuiOutlinedInput-input {
        border: none !important;
        height: 50px;
        background: #fff
    }

    .MuiInputBase-root .MuiOutlinedInput-notchedOutline {
        border: 2px solid #909a9f
    }

    .MuiInputBase-root .MuiOutlinedInput-notchedOutline:focus, .MuiInputBase-root .MuiOutlinedInput-notchedOutline:hover {
        border: 2px solid #101728
    }

    .MuiButtonBase-root, .MuiDayPicker-weekDayLabel, .MuiPickersCalendarHeader-label, .PrivatePickersYear-yearButton {
        font-family: "29LT Bukra" !important
    }

    .data-password {
        margin-top: 15px;
        margin-bottom: 30px
    }

    .data-password .title-data-pass {
        margin: 15px 0
    }

    .data-password ul li {
        color: #4d5a61;
        font-weight: 400;
        line-height: 30px;
        display: flex;
        align-items: center
    }

    .data-password ul li svg {
        font-size: 15px;
        -webkit-padding-end: 10px;
        padding-inline-end: 10px
    }

    .data-password ul li .icon-done {
        display: none
    }

    .data-password ul li.done {
        color: #179f67
    }

    .data-password ul li.done .icon-done {
        display: block
    }

    .data-password ul li.done .icon-done svg {
        color: #179f67;
        display: block !important;
        font-size: 20px
    }

    .data-password ul li.done svg {
        display: none
    }

    .icon-password {
        position: absolute;
        left: 11px;
        bottom: 11px
    }

    .icon-password svg {
        font-size: 17px;
        color: #909a9f
    }

    .blockBeforeLogin {
        display: flex;
        align-items: center
    }

    .btn-header {
        -webkit-margin-start: 8px;
        margin-inline-start: 8px;
        padding: 0 7px
    }

    .btn-logout {
        color: #b72626;
        display: flex;
        align-items: center
    }

    .btn-logout:after {
        content: "";
        display: inline-block;
        background: url(/_next/static/media/logout.ac57314a.svg);
        background-repeat: no-repeat;
        background-size: contain;
        width: 23px;
        height: 21px
    }

    .blockForm {
        margin-bottom: 40px
    }

    .blockForm .titleBlock {
        color: #006fb7;
        font-size: 16px;
        border-bottom: 2px solid #edeff0;
        padding-bottom: 7px;
        margin-bottom: 30px
    }

    .blockForm .titleBlock span {
        display: inline-block
    }

    .blockForm .titleBlock span .ifFound {
        font-weight: 400;
        font-size: 12px;
        -webkit-margin-start: 10px;
        margin-inline-start: 10px
    }

    .blockForm .titleBlock span .ifFound:after {
        display: none
    }

    .blockForm .titleBlock span:after {
        content: "";
        background: #006fb7;
        width: auto;
        height: 4px;
        display: block;
        border-radius: 5px;
        position: relative;
        top: 10px
    }

    .blockForm .titleBlock.titleWithLeft {
        display: flex;
        justify-content: space-between
    }

    .blockForm .titleBlock.titleWithLeft span:after {
        display: none
    }

    .dataForm {
        display: flex;
        flex-wrap: wrap
    }

    .dataForm .groupItemShow {
        width: 25%;
        margin-bottom: 35px
    }

    .dataForm .groupItemShow .lableShow {
        color: #909a9f;
        margin-bottom: 10px;
        font-size: 12px
    }

    .dataForm .groupItemShow .showData {
        color: #101728;
        display: flex;
        align-items: center;
        font-size: 12px
    }

    .dataForm .groupItemShow .showData svg {
        font-size: 17px;
        -webkit-margin-end: 7px;
        margin-inline-end: 7px
    }

    .dataForm .groupItemShow .showData.datWithList {
        align-items: flex-start
    }

    .dataForm .groupItemShow .showData.datWithList ul li {
        margin-bottom: 8px;
        list-style-type: disc;
        -webkit-margin-start: 16px;
        margin-inline-start: 16px
    }

    .dataForm .groupItemShow .showData.withText a {
        color: #8fceca;
        -webkit-margin-start: 5px;
        margin-inline-start: 5px
    }

    .dataForm .groupItemShow .showData.withText a:hover {
        color: #179f67
    }

    .dataForm .groupItemShow .showData.data-link a {
        color: #8fceca
    }

    .dataForm .groupItemShow .showData.data-link a svg {
        font-size: 18px
    }

    .dataForm .groupItemShow .showData.data-link a:hover {
        color: #179f67
    }

    .dataForm.dataFormTwo .groupItemShow {
        width: 50%;
        margin-bottom: 15px
    }

    .dataForm.dataFormFive .groupItemShow {
        width: 20%;
        margin-bottom: 15px
    }

    .dataForm.oneBlock .groupItemShow {
        width: 100%;
        margin-bottom: 15px
    }

    .dataForm.bordered {
        padding: 24px 16px 0;
        margin-bottom: 24px;
        border: 2px solid #edeff0;
        border-radius: 10px
    }

    .TableNhc {
        display: flex;
        flex-wrap: wrap
    }

    .TableNhc .headerItemTbl {
        background: #f8fbfc
    }

    .TableNhc .headerItemTbl.rowTabel .colTbl {
        font-size: 13px
    }

    .TableNhc .rowTabel {
        display: flex;
        width: 100%;
        height: 50px;
        align-items: center;
        border-bottom: 1px solid #edeff0;
        transition: background-color .2s;
        cursor: pointer
    }

    .TableNhc .rowTabel:hover {
        background-color: #f4f8fa
    }

    .TableNhc .rowTabel .colTbl {
        padding: 0 15px;
        font-size: 11px
    }

    .TableNhc .rowTabel .colTbl.custom-col1 {
        width: 25%
    }

    .TableNhc .rowTabel .colTbl.custom-col2 {
        width: 20%;
        text-align: center
    }

    .TableNhc .rowTabel .colTbl.custom-col3 {
        width: 55%
    }

    .TableNhc .rowTabel .colTbl.tilteCol a {
        color: #004f83
    }

    .TableNhc .rowTabel .colTbl.tilteCol a:hover {
        color: #006fb7
    }

    .TableNhc .rowTabel .colTbl.actionColBlck {
        display: flex;
        justify-content: space-between;
        align-items: center
    }

    .TableNhc .rowTabel .colTbl.actionColBlck .btnAction svg {
        color: #909a9f;
        font-size: 24px
    }

    .TableNhc .rowTabel .colTbl.actionsCol {
        display: flex;
        justify-content: flex-end;
        align-items: center
    }

    .TableNhc .rowTabel .colTbl.actionsCol .btnAction svg {
        color: #909a9f;
        font-size: 24px
    }

    .TableNhc.tblContracts .rowTabel {
        width: 100%;
        justify-content: space-between;
        cursor: pointer;
        transition: background-color .2s
    }

    .TableNhc.tblContracts .rowTabel .colTbl {
        width: 18%;
        display: flex;
        align-items: center
    }

    .TableNhc.tblContracts .rowTabel:hover {
        background-color: #f4f8fa
    }

    .TableNhc.tblContracts .rowTabel:active {
        background-color: #e9f2f7
    }

    .TableNhc.tblContracts .rowTabel .tilteCol a {
        text-decoration: underline
    }

    .TableNhc.tblContracts .rowTabel .actionColBlck {
        width: 21%
    }

    .TableNhc.tblContracts.tblContractsAdv .col1 {
        width: 5%
    }

    .TableNhc.tblContracts.tblContractsAdv .col2 {
        width: 10%
    }

    .TableNhc.tblContracts.tblContractsAdv .col3 {
        width: 20%
    }

    .TableNhc.tblContracts.tblContractsAdv .col4 {
        width: 32%
    }

    .TableNhc.tblContracts.tblContractsAdv .col5 {
        width: 33%
    }

    #menuAction .MuiMenu-paper {
        width: 180px !important;
        padding-top: 0;
        margin-top: 0
    }

    #menuAction .MuiMenu-paper li {
        color: #101728;
        font-weight: 700;
        border-bottom: 1px solid #edeff0;
        padding-bottom: 15px;
        padding-top: 10px
    }

    #menuAction .MuiMenu-paper li:hover {
        color: #0291d3;
        background: transparent
    }

    #menuAction .MuiMenu-paper li:last-child {
        border: none;
        padding-bottom: 0
    }

    .btn-Service {
        max-width: 170px;
        margin: 0 !important
    }

    .btn-Service svg {
        margin-left: 10px
    }

    .linkLicenseDetails {
        justify-content: space-between
    }

    .linkLicenseDetails a {
        display: flex;
        justify-content: center;
        align-items: center;
        color: #006fb7;
        font-size: 12px
    }

    .linkLicenseDetails a svg {
        -webkit-margin-start: 5px;
        margin-inline-start: 5px
    }

    .linkLicenseDetails a:hover {
        color: #004f83
    }

    .colorBlue {
        color: #006fb7
    }

    .colorBlue:hover {
        color: #004f83
    }

    .dateContract {
        display: flex;
        align-items: center;
        font-size: 12px
    }

    .dateContract svg {
        -webkit-margin-end: 7px;
        margin-inline-end: 7px;
        font-size: 17px
    }

    .MuiFormGroup-root {
        margin: 10px 0 0
    }

    .MuiFormGroup-row .MuiFormControlLabel-root {
        margin: 0;
        -webkit-margin-end: 15px;
        margin-inline-end: 15px
    }

    .MuiFormGroup-row .MuiRadio-root {
        padding: 0
    }

    .MuiFormControlLabel-label {
        font-family: "29LT Bukra"
    }

    .blockForm sub {
        margin-bottom: 15px
    }

    .link_licenses {
        color: #616161
    }

    .inputRadioGroup-block {
        margin-bottom: 15px
    }

    .DataPickerNew {
        width: 100%;
        height: 46px;
        font-family: "29LT Bukra";
        border: 2px solid #909a9f;
        border-radius: 6px;
        padding: 0 20px;
        color: #000;
        font-weight: 700;
        font-size: 12px;
        transition: all .5s;
        justify-content: flex-start
    }

    .DataPickerNew:focus, .DataPickerNew:hover {
        border-radius: 6px;
        border: 2px solid #101728;
        background: transparent !important
    }

    .DataPickerNew svg {
        position: absolute;
        left: 10px
    }

    .rmdp-day span, .rmdp-week-day span {
        font-size: 10px !important
    }

    .rmdp-day, .rmdp-week-day {
        font-size: 12px !important
    }

    .rmdp-rtl {
        width: 400px
    }

    .rmdp-wrapper {
        width: 100% !important
    }

    .rmdp-day-picker:first-child div {
        width: 100%
    }

    .rmdp-day span {
        border-radius: 5px !important
    }

    .rmdp-shadow {
        box-shadow: none !important
    }

    .rmdp-day.rmdp-selected span:not(.highlight) {
        background-color: #254065 !important
    }

    .rmdp-day.rmdp-today span, .rmdp-day:not(.rmdp-disabled):not(.rmdp-day-hidden) span:hover {
        background-color: rgba(37, 64, 101, .62) !important
    }

    .holder-date {
        position: absolute;
        bottom: -20px;
        font-size: 11px;
        color: #254065
    }

    .small-desc {
        color: #4d5a61;
        font-weight: 500;
        font-size: 11px;
        margin-top: 10px
    }

    .inputDropZone {
        transition: all .2;
        margin-top: 15px;
        padding: 16px;
        border: 2px dashed #909a9f;
        border-radius: 6px;
        height: 150px
    }

    .inputDropZone .dataInnerDropZone {
        height: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        color: #101728;
        line-height: 27px;
        font-size: 12px
    }

    .inputDropZone .dataInnerDropZone .secndDesc {
        color: #909a9f
    }

    .inputDropZone .dataInnerDropZone .secndDesc span {
        color: #006fb7
    }

    .inputDropZone .dataInnerDropZone .secndDesc span:hover {
        cursor: pointer
    }

    .inputDropZone .pulse {
        animation: pulseAnimation .7s ease-in-out infinite alternate
    }

    .descInputDropZone {
        color: #909a9f;
        font-size: 12px;
        margin-top: 10px
    }

    .descInputDropZone li {
        padding-top: 8px
    }

    .imgDropZone {
        margin-top: 15px;
        display: flex;
        flex-wrap: wrap
    }

    .imgDropZone.oneLine {
        display: block;
        flex-wrap: nowrap
    }

    .imgDropZone .imgItem {
        position: relative;
        margin: 9px;
        border-radius: 10px
    }

    .imgDropZone .imgItem .imgItemZone {
        border-radius: 10px;
        width: 181px;
        height: 128px;
        -o-object-fit: cover;
        object-fit: cover
    }

    .imgDropZone .imgItem .delateImg {
        background: hsla(0, 0%, 100%, .7);
        width: 40px;
        height: 40px;
        position: absolute;
        right: 7px;
        top: 7px;
        display: flex;
        justify-content: center;
        align-items: center;
        color: #b72626;
        box-shadow: 0 3px 6px rgba(0, 0, 0, .08);
        border-radius: 100%;
        z-index: 1;
        cursor: pointer;
        transition: all .5s
    }

    .imgDropZone .imgItem .delateImg svg {
        font-size: 25px
    }

    .imgDropZone .imgItem .delateImg:hover {
        background: hsla(0, 0%, 100%, .6)
    }

    .imgDropZone .imgItem .cropImageHint {
        color: #b72626;
        font-size: smaller;
        text-align: center
    }

    .btnMap {
        margin: 0 !important;
        padding: 0 14px !important
    }

    .conditionBlock label {
        margin: 0
    }

    @keyframes pulseAnimation {
        0% {
            transform: scale(1) translateY(0)
        }
        to {
            transform: scale(1.2) translateY(-5px)
        }
    }

    .btn-footerRightLeft, .footer-emp-details {
        display: flex;
        justify-content: space-between
    }

    .MuiAutocomplete-root {
        border: 2px solid #909a9f;
        border-radius: 6px;
        height: 50px;
        overflow: auto
    }

    .MuiAutocomplete-root .MuiInputBase-input {
        padding: 0 !important
    }

    .MuiAutocomplete-root .MuiInputBase-root {
        padding: 0
    }

    .MuiAutocomplete-root .MuiInputBase-root .MuiOutlinedInput-notchedOutline {
        border: none
    }

    .MuiAutocomplete-root .css-1dybbl5-MuiChip-label {
        padding-left: 5px;
        padding-right: 5px
    }

    .MuiAutocomplete-root .MuiChip-deleteIcon {
        margin: 0 0 0 -6px
    }

    .MuiAutocomplete-root .MuiFormLabel-root {
        display: none
    }

    .check-terms .form-check-input {
        width: auto;
        padding: 0;
        margin: 0;
        align-self: center;
        -webkit-margin-end: 15px;
        margin-inline-end: 15px
    }

    .check-terms label {
        line-height: 25px
    }

    .check-auctions .check-box {
        width: auto;
        padding: 0;
        margin: 0;
        align-self: center;
        -webkit-margin-end: 15px;
        margin-inline-end: 15px
    }

    .check-auctions label {
        line-height: 60px
    }

    .containerLicensesOptions {
        display: grid;
        grid-template-columns:60% 30%;
        grid-gap: 63px;
        gap: 63px;
        margin-top: 30px
    }

    ul.courses-list {
        padding-top: 20px;
        display: flex;
        justify-content: space-around;
        flex-direction: column;
        gap: 10px;
        list-style-type: disc
    }

    ul.courses-list li {
        display: flex;
        width: 500px;
        justify-content: space-between
    }

    ul.courses-list li .course-name {
        font-weight: 400
    }

    ul.courses-list a {
        display: flex;
        gap: 9px;
        align-items: center;
        color: #004f83
    }

    .list-desc {
        list-style-type: disc;
        line-height: 26px
    }

    .amountMsg {
        position: absolute;
        bottom: 0;
        font-weight: 500;
        font-size: 9px
    }

    .amountMsg.with-error {
        bottom: -20px
    }

    .header {
        background: #fff;
        height: 80px;
        box-shadow: 1px 2px 6px rgba(0, 0, 0, .05);
        position: relative;
        z-index: 2
    }

    .header .container {
        height: 100%
    }

    .header .logo img {
        height: 60px !important
    }

    .header .logo-not-clickable {
        cursor: default
    }

    .header .logo-not-clickable img {
        height: 60px !important
    }

    .header .block-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        height: 100%
    }

    .header .block-header .testReleaseContainer {
        display: flex;
        flex-direction: row;
        align-items: center
    }

    .header .block-header .testReleaseBadge {
        margin-right: 56px;
        padding: 12px;
        background-color: #8dcecc;
        color: #fff;
        border-radius: 5px;
        box-shadow: 1px 1px 2px #ccc
    }

    .header .checkMenu {
        display: none
    }

    .btn-with-avater {
        display: flex;
        align-items: center
    }

    .avater-name {
        background: rgba(143, 206, 202, .2);
        border-radius: 100px;
        width: 35px;
        height: 35px;
        color: #8fceca
    }

    .avater-img img, .avater-name {
        display: flex;
        justify-content: center;
        align-items: center;
        -webkit-margin-end: 10px;
        margin-inline-end: 10px
    }

    .avater-img img {
        width: 40px;
        height: 40px;
        display: none
    }

    .blockShowName {
        display: none
    }

    .data-header-afterLogin {
        display: flex;
        flex: 1 1;
        align-items: center;
        justify-content: flex-end
    }

    .data-header-afterLogin .changeRole {
        -webkit-margin-end: 30px;
        margin-inline-end: 30px
    }

    .data-header-afterLogin .changeRole a {
        display: flex;
        align-items: center;
        color: #004f83
    }

    .data-header-afterLogin .changeRole a svg {
        -webkit-margin-end: 8px;
        margin-inline-end: 8px
    }

    .data-header-afterLogin .changeRole a:hover {
        color: #006fb7
    }

    .data-header-afterLogin .block-facility-header {
        cursor: pointer;
        display: flex;
        align-items: center
    }

    .data-header-afterLogin .block-facility-header .facility-data {
        margin: 0 6px
    }

    .data-header-afterLogin .block-facility-header .facility-data .name-facility {
        color: #263238
    }

    .data-header-afterLogin .block-facility-header .facility-data .role-facility {
        font-weight: 400;
        color: #263238;
        margin-top: 5px
    }

    .data-header-afterLogin .block-facility-header .arrowDown {
        cursor: pointer;
        min-width: inherit
    }

    .data-header-afterLogin .block-facility-header .arrowDown svg {
        color: #8fceca
    }

    .data-header-afterLogin .layout-switcher {
        width: 240px;
        color: #006fb7
    }

    .data-header-afterLogin .layout-switcher svg {
        margin-left: 8px
    }

    .MenuMobile, .MuiMenu-paper {
        width: 220px;
        box-shadow: 0 20px 60px 6px rgba(0, 0, 0, .05);
        margin-top: 24px;
        padding: 20px 15px 15px
    }

    .MenuMobile .menuleft-header ul li, .MuiMenu-paper .menuleft-header ul li {
        position: relative;
        display: flex;
        align-items: center;
        margin-bottom: 15px
    }

    .MenuMobile .menuleft-header ul li.disabled a, .MuiMenu-paper .menuleft-header ul li.disabled a {
        color: #ccc;
        cursor: no-drop
    }

    .MenuMobile .menuleft-header ul li.disabled a svg, .MenuMobile .menuleft-header ul li.disabled a:hover, .MenuMobile .menuleft-header ul li.disabled a:hover svg, .MuiMenu-paper .menuleft-header ul li.disabled a svg, .MuiMenu-paper .menuleft-header ul li.disabled a:hover, .MuiMenu-paper .menuleft-header ul li.disabled a:hover svg {
        color: #ccc
    }

    .MenuMobile .menuleft-header ul li a, .MuiMenu-paper .menuleft-header ul li a {
        display: flex;
        align-items: center;
        color: #263238;
        font-size: 11px
    }

    .MenuMobile .menuleft-header ul li a img, .MenuMobile .menuleft-header ul li a svg, .MuiMenu-paper .menuleft-header ul li a img, .MuiMenu-paper .menuleft-header ul li a svg {
        color: #263238;
        -webkit-margin-end: 10px;
        margin-inline-end: 10px
    }

    .MenuMobile .menuleft-header ul li a:hover, .MenuMobile .menuleft-header ul li a:hover svg, .MuiMenu-paper .menuleft-header ul li a:hover, .MuiMenu-paper .menuleft-header ul li a:hover svg {
        color: #004f83
    }

    .MenuMobile .menuleft-header ul li:hover a, .MenuMobile .menuleft-header ul li:hover a svg, .MuiMenu-paper .menuleft-header ul li:hover a, .MuiMenu-paper .menuleft-header ul li:hover a svg {
        color: #006fb7
    }

    .MenuMobile .menuleft-header ul li.active a, .MenuMobile .menuleft-header ul li.active a svg, .MuiMenu-paper .menuleft-header ul li.active a, .MuiMenu-paper .menuleft-header ul li.active a svg {
        color: #004f83
    }

    .MenuMobile .menuleft-header ul li.active:after, .MuiMenu-paper .menuleft-header ul li.active:after {
        content: "";
        display: block;
        background: #004f83;
        width: 10px;
        height: 10px;
        border-radius: 100%;
        position: absolute;
        left: 0
    }

    .MenuMobile .menuleft-header ul.bisc-menu, .MuiMenu-paper .menuleft-header ul.bisc-menu {
        border-top: 1px solid #edeff0;
        border-bottom: 1px solid #edeff0;
        margin-top: 20px !important;
        padding-top: 20px
    }

    .MenuMobile .menuleft-header ul.bisc-menu li a, .MuiMenu-paper .menuleft-header ul.bisc-menu li a {
        font-size: 12px
    }

    .MenuMobile .menuleft-header ul.bisc-menu li.link-logout a, .MuiMenu-paper .menuleft-header ul.bisc-menu li.link-logout a {
        color: #b72626
    }

    .MenuMobile .menuleft-header ul.bisc-menu li.link-logout a:before, .MuiMenu-paper .menuleft-header ul.bisc-menu li.link-logout a:before {
        content: "";
        display: block;
        background: url(/_next/static/media/logout.ac57314a.svg);
        background-repeat: no-repeat;
        background-size: contain;
        width: 22px;
        height: 22px;
        -webkit-margin-end: 10px;
        margin-inline-end: 10px
    }

    .MenuMobile .menuleft-header .dataLoginUser, .MuiMenu-paper .menuleft-header .dataLoginUser {
        color: #909a9f;
        font-size: 12px;
        font-weight: 400;
        line-height: 24px;
        margin-top: 7px
    }

    .MenuMobile .menuleft-header .menuOffice, .MuiMenu-paper .menuleft-header .menuOffice {
        border-top: 1px solid #edeff0;
        padding-top: 20px
    }

    .MenuMobile .menuleft-header .menuOffice:first-child, .MuiMenu-paper .menuleft-header .menuOffice:first-child {
        border-top: none;
        padding-top: 0
    }

    .MenuMobile .menuleft-header .menuOffice li a, .MuiMenu-paper .menuleft-header .menuOffice li a {
        flex-wrap: wrap
    }

    .MenuMobile .menuleft-header .menuOffice li a .officeNameMenuItemBlock, .MuiMenu-paper .menuleft-header .menuOffice li a .officeNameMenuItemBlock {
        display: flex;
        align-items: center
    }

    .MenuMobile .menuleft-header .menuOffice li a .officeNameMenuSubItem, .MuiMenu-paper .menuleft-header .menuOffice li a .officeNameMenuSubItem {
        font-weight: 400;
        margin-right: 35px
    }

    .MenuMobile.MenuMobile, .MuiMenu-paper.MenuMobile {
        width: auto;
        box-shadow: none;
        margin-top: inherit
    }

    .MenuMobile.MenuMobile .menuOffice, .MenuMobile.MenuMobile .sidebar-mobile, .MuiMenu-paper.MenuMobile .menuOffice, .MuiMenu-paper.MenuMobile .sidebar-mobile {
        padding-top: 20px;
        border-top: 1px solid #edeff0
    }

    .MenuMobile.MenuMobile .title-sidebar-mobile, .MuiMenu-paper.MenuMobile .title-sidebar-mobile {
        margin-bottom: 20px;
        color: #909a9f
    }

    .MenuMobile.MenuMobile .changeRole, .MuiMenu-paper.MenuMobile .changeRole {
        margin-bottom: 20px
    }

    .MenuMobile.MenuMobile .changeRole a, .MuiMenu-paper.MenuMobile .changeRole a {
        display: flex;
        align-items: center;
        color: #004f83;
        font-size: 15px
    }

    .MenuMobile.MenuMobile .changeRole a svg, .MuiMenu-paper.MenuMobile .changeRole a svg {
        font-size: 25px;
        -webkit-margin-end: 15px;
        margin-inline-end: 15px
    }

    .alertMsg {
        border-radius: 6px;
        font-weight: 400;
        font-size: 14px;
        padding: 15px;
        display: flex;
        align-items: center;
        margin-bottom: 15px
    }

    .alertMsg:before {
        content: "";
        width: 17px;
        height: 17px;
        display: inline-block;
        background-repeat: no-repeat;
        background-size: contain;
        -webkit-margin-end: 10px;
        margin-inline-end: 10px
    }

    .alertMsg.successMsg {
        background: #d6ecf6
    }

    .alertMsg.errorMsg {
        background: #fdd
    }

    .alertMsg.errorMsg:before {
        content: "";
        background: url(/_next/static/media/info-circle-red.4fa7b72a.svg);
        background-size: contain;
        background-repeat: no-repeat
    }

    .alertMsg.alert-warring {
        background: #faefd7;
        width: -moz-fit-content;
        width: fit-content
    }

    .alertMsg.alert-warring svg {
        color: #e4b449;
        -webkit-margin-end: 10px;
        margin-inline-end: 10px
    }

    .alertMsg.alert-warring:before {
        display: none
    }

    .dailogOtp .MuiPaper-root {
        width: 520px !important;
        border-radius: 10px;
        padding: 40px
    }

    .dailogYesNo .MuiPaper-root {
        padding: 0
    }

    .dailogYesNo .MuiDialogTitle-root {
        padding: 0;
        border-bottom: 1px solid #edeff0
    }

    .dailogYesNo .MuiDialogTitle-root .DialogTitleBlock {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 15px 30px
    }

    .dailogYesNo .MuiDialogTitle-root .DialogTitleBlock .DialogTitle {
        display: flex;
        align-items: center
    }

    .dailogYesNo .MuiDialogTitle-root .DialogTitleBlock .DialogTitle .nameTitle {
        color: #101728;
        font-size: 16px
    }

    .dailogYesNo .MuiDialogTitle-root .DialogTitleBlock .DialogTitle .bgVariant {
        background: #f8fbfc;
        width: 45px;
        height: 45px;
        border-radius: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        -webkit-margin-end: 10px;
        margin-inline-end: 10px
    }

    .dailogYesNo .MuiDialogTitle-root .DialogTitleBlock .btnCloseDialog {
        font-size: 24px
    }

    .dailogYesNo .DialogContentBlock {
        padding: 30px
    }

    .dailogYesNo .DialogContentBlock .contentTitle {
        color: #101728;
        font-size: 16px;
        margin-bottom: 15px
    }

    .dailogYesNo .DialogContentBlock .contentDesc {
        color: #101728;
        font-weight: 400;
        line-height: 27px
    }

    .dailogYesNo .DialogActionsBlock {
        border-top: 1px solid #edeff0;
        padding: 15px 30px
    }

    .dailogYesNo .DialogActionsBlock button {
        height: 45px;
        padding: 0 20px;
        -webkit-margin-start: 15px;
        margin-inline-start: 15px
    }

    .MuiDialogTitle-root {
        font-family: "29LT Bukra";
        color: #254065;
        padding: 25px 15px;
        text-align: right
    }

    .MuiDialogContentText-root {
        font-family: "29LT Bukra";
        font-weight: 400;
        font-size: 14px;
        line-height: 24px;
        direction: rtl;
        text-align: right;
        color: #101728;
        height: 350px
    }

    .SnackbarItem-message {
        font-family: "29LT Bukra"
    }

    .statusNhc {
        padding: 8px 16px;
        display: inline-flex;
        border-radius: 4px;
        font-size: 11px
    }

    .statusNhc.statusSuccess {
        background: #d3f3d4;
        color: #179f67
    }

    .statusNhc.statusDanger {
        background: #fdd;
        color: #b72626
    }

    .statusNhc.statusWaitingForActivation {
        background: #d6ecf6;
        color: #0291d3
    }

    .statusNhc.statusNotAccredited {
        background: #f5f8f8;
        color: #909a9f
    }

    .statusNhc.statusWarning {
        background: #faefd7;
        color: #e4b449
    }

    .statusNhc.statusPrimary {
        background: #d6ecf6;
        color: #0291d3
    }

    .statusNhc.statusSecondary {
        background: #f5f8f8;
        color: #909a9f
    }

    .statusGreen {
        background: #d3f3d4;
        border-radius: 4px;
        color: #179f67;
        padding: 10px
    }

    .statusError {
        background: #fdd;
        color: #b72626;
        padding: 10px
    }

    .alertUpdate {
        display: inline-block;
        background: #d6ecf6;
        border-radius: 6px;
        padding: 20px
    }

    .alertUpdate .text-alertUpdate {
        font-weight: 400;
        display: flex;
        align-items: center
    }

    .alertUpdate .text-alertUpdate svg {
        -webkit-margin-end: 10px;
        margin-inline-end: 10px;
        color: #0291d3
    }

    .alertUpdate a {
        border: 1px solid #101728;
        border-radius: 6px;
        display: inline-flex;
        align-items: center;
        color: #101728;
        height: 45px;
        padding: 0 15px;
        margin-top: 20px;
        -webkit-margin-start: 25px;
        margin-inline-start: 25px
    }

    .alertUpdate a:hover {
        box-shadow: 0 3px 6px rgba(0, 0, 0, .08);
        background: #fff
    }

    .alertUpdate button {
        cursor: pointer;
        background: transparent;
        font-family: "29LT Bukra";
        font-weight: 500;
        border: 1px solid #101728;
        border-radius: 6px;
        display: inline-flex;
        align-items: center;
        color: #101728;
        height: 45px;
        padding: 0 15px;
        margin-top: 20px;
        -webkit-margin-start: 25px;
        margin-inline-start: 25px
    }

    .alertUpdate button:hover {
        box-shadow: 0 3px 6px rgba(0, 0, 0, .08);
        background: #fff
    }

    .MenuEmp .MuiMenu-paper {
        margin-top: 0 !important;
        width: 200px;
        box-shadow: 0 3px 6px rgba(0, 0, 0, .08)
    }

    .MenuEmp .MuiMenu-paper li {
        display: flex;
        align-items: center;
        margin-bottom: 10px;
        padding-bottom: 10px;
        border-bottom: 1px solid #edeff0;
        color: #101728;
        cursor: pointer;
        font-size: 12px
    }

    .MenuEmp .MuiMenu-paper li svg {
        -webkit-margin-end: 7px;
        margin-inline-end: 7px
    }

    .MenuEmp .MuiMenu-paper li:last-child {
        border: none;
        margin-bottom: 0;
        padding-bottom: 0
    }

    .MenuEmp .MuiMenu-paper .deleteEmp {
        color: #b72626;
        padding-right: 4px;
        padding-top: 16px;
        padding-bottom: 16px !important;
        display: flex;
        text-align: center
    }

    .MenuEmp .MuiMenu-paper .deleteEmp:hover {
        background-color: #fffbfb
    }

    .MenuEmp .MuiMenu-paper .deleteEmp:active {
        background-color: #fff5f5
    }

    .MenuEmp .MuiButton-root {
        padding: 0;
        min-width: none
    }

    .customMenu .MuiMenu-paper li.primary {
        color: #153264;
        font-weight: 700
    }

    .customMenu .MuiMenu-paper li.primary svg {
        color: #153264;
        -webkit-margin-end: 7px;
        margin-inline-end: 7px
    }

    .customMenu .MuiButton-root {
        padding: 0;
        min-width: none
    }

    .termsAndConditionsModel .MuiPaper-root {
        max-width: 820px
    }

    .MuiTooltip-tooltip {
        font-family: "29LT Bukra";
        padding: 10px;
        font-size: 14px;
        max-width: 380px;
        font-weight: 400;
        line-height: 27px
    }

    .container-fluid {
        padding: 0 20px;
        display: flex;
        align-items: center;
        height: 100%
    }

    .container-fluid .block-header {
        width: 100%
    }

    .container-fluid .block-header .btn-logout {
        padding: 0;
        -webkit-padding-start: 20px;
        padding-inline-start: 20px
    }

    .section-content-basepage {
        display: flex;
        position: relative;
        z-index: 1;
        min-height: calc(100vh - 80px)
    }

    .section-content-basepage .sidebar-right {
        width: 280px;
        background: #f8fbfc;
        box-shadow: 0 3px 6px rgba(0, 0, 0, .08);
        border-radius: 0;
        padding: 40px 15px
    }

    .section-content-basepage .sidebar-right .title-sidebar {
        color: #101728;
        font-weight: 400;
        margin-bottom: 20px
    }

    .section-content-basepage .sidebar-right ul li {
        margin-bottom: 5px
    }

    .section-content-basepage .sidebar-right ul li a {
        display: flex;
        align-items: center;
        color: #263238;
        padding: 12px 10px
    }

    .section-content-basepage .sidebar-right ul li a svg {
        -webkit-margin-end: 15px;
        margin-inline-end: 15px
    }

    .section-content-basepage .sidebar-right ul li a:hover {
        background: #d6ecf6;
        border-radius: 6px;
        color: #006fb7
    }

    .section-content-basepage .sidebar-right ul li a:hover svg {
        color: #006fb7
    }

    .section-content-basepage .sidebar-right ul li.active a, .section-content-basepage .sidebar-right ul li:active .section-content-basepage .sidebar-right ul li:hover a {
        background: #d6ecf6;
        border-radius: 6px;
        color: #006fb7
    }

    .section-content-basepage .sidebar-right ul li.active a svg, .section-content-basepage .sidebar-right ul li:active .section-content-basepage .sidebar-right ul li:hover a svg {
        color: #006fb7
    }

    .section-content-basepage .sidebar-right ul li.disabled.active, .section-content-basepage .sidebar-right ul li.disabled:active .section-content-basepage .sidebar-right ul li.disabled:hover {
        background: red
    }

    .section-content-basepage .sidebar-right ul li.disabled a {
        color: #aaa;
        cursor: no-drop
    }

    .section-content-basepage .sidebar-right ul li.disabled a:hover {
        background: transparent !important
    }

    .section-content-basepage .sidebar-right ul li.disabled a:hover svg {
        color: #aaa
    }

    .section-content-basepage .main-content {
        width: 100%;
        background: #fff;
        padding: 30px
    }

    .breadCrumb {
        margin-bottom: 30px;
        color: #8fceca;
        color: #263238
    }

    .breadCrumb, .breadCrumb a {
        display: flex;
        align-items: center
    }

    .breadCrumb a {
        color: #004f83;
        color: #8fceca
    }

    .breadCrumb a .shapow {
        font-size: 19px;
        position: relative;
        display: flex;
        align-items: center;
        color: #909a9f;
        margin: 0 4px
    }

    .breadCrumb a:hover {
        color: #6bb0cf
    }

    .title-inner-page {
        color: #153264;
        font-size: 17px
    }

    .title-inner-page.title-withLink {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 20px
    }

    .title-inner-page.title-withLink .add-new-licens a {
        margin: 0
    }

    .title-inner-page .details-title {
        color: #263238;
        font-size: 12px;
        font-weight: 400;
        margin-right: 7px
    }

    .title-inner-page .left-title, .title-inner-page .left-title .searchBtn {
        display: flex;
        justify-content: center;
        align-items: center
    }

    .title-inner-page .left-title .searchBtn {
        color: #006fb7;
        border: 2px solid #006fb7;
        box-shadow: 0 3px 6px rgba(0, 0, 0, .08);
        border-radius: 6px;
        min-width: auto;
        width: 45px;
        height: 45px;
        cursor: pointer;
        -webkit-margin-start: 10px;
        margin-inline-start: 10px
    }

    .title-inner-page .left-title .searchBtn:hover {
        border: 2px solid #004f83;
        color: #004f83
    }

    .emptyPage, .index-page-licens {
        height: 100%
    }

    .emptyPage .empty-licens, .index-page-licens .empty-licens {
        text-align: center;
        color: #263238;
        font-size: 16px;
        height: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column
    }

    .emptyPage .empty-licens .image-empty, .index-page-licens .empty-licens .image-empty {
        background-image: url(/_next/static/media/empty-licenses.35a42e3b.svg);
        background-repeat: no-repeat;
        background-position: 50%;
        background-size: contain;
        width: 152px;
        height: 158px;
        margin: 30px auto
    }

    .emptyPage .details-404, .index-page-licens .details-404 {
        color: #b72626
    }

    .emptyPage .desc-emp-page, .index-page-licens .desc-emp-page {
        font-weight: 300;
        margin-top: 10px
    }

    .add-new-licens {
        text-align: center
    }

    .add-new-licens a {
        width: auto;
        padding: 0 20px;
        height: 45px;
        color: #fff;
        background: #006fb7;
        box-shadow: 0 3px 6px rgba(0, 0, 0, .08);
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 30px auto;
        font-size: 12px
    }

    .add-new-licens a svg {
        -webkit-margin-end: 7px;
        margin-inline-end: 7px
    }

    .add-new-licens a:hover {
        background: #004f83
    }

    .show-licenses .item-licens {
        background: #fff;
        border: 1px solid #f5f8f8;
        box-shadow: 0 20px 60px 6px rgba(0, 0, 0, .05);
        border-radius: 10px;
        justify-content: space-between
    }

    .show-licenses .item-licens, .show-licenses .item-licens .right-licens {
        display: flex;
        align-items: center
    }

    .show-licenses .item-licens .right-licens .name-licens {
        color: #101728;
        font-size: 17px;
        -webkit-margin-end: 20px;
        margin-inline-end: 20px
    }

    .show-licenses .item-licens .right-licens .status-licens {
        background: #d3f3d4;
        border-radius: 4px;
        color: #179f67;
        padding: 12px 15px
    }

    .show-licenses .item-licens .left-licens {
        display: flex
    }

    .show-licenses .item-licens .left-licens .link-licens {
        border: 2px solid #8fceca;
        box-shadow: 0 3px 6px rgba(0, 0, 0, .08);
        border-radius: 6px;
        color: #8fceca;
        display: block
    }

    .MuiBox-root, .MuiBox-root p {
        font-family: "29LT Bukra" !important
    }

    .MuiBox-root p {
        font-weight: 500
    }

    .tabs-top {
        margin-bottom: 30px;
        border-bottom: 1px solid #edeff0;
        display: inline-block;
        font-family: "29LT Bukra"
    }

    .tabs-top .MuiTabs-indicator {
        height: 3px;
        border-radius: 100px;
        background: #006fb7
    }

    .tabs-top .MuiButtonBase-root {
        color: #263238;
        font-size: 14px
    }

    .tabs-top .MuiButtonBase-root.Mui-selected {
        color: #006fb7
    }

    .title-page {
        color: #153264;
        font-size: 14px;
        margin-bottom: 30px
    }

    .title-page.title-leftDetails {
        display: flex;
        justify-content: space-between
    }

    .title-page.title-leftDetails .left-title {
        display: flex
    }

    .title-page.title-leftDetails .left-title a {
        display: flex;
        align-items: center;
        -webkit-margin-start: 15px;
        margin-inline-start: 15px;
        color: #006fb7;
        font-size: 12px
    }

    .title-page.title-leftDetails .left-title a:hover {
        color: #004f83
    }

    .page-subtitle {
        margin-bottom: 30px
    }

    .page-subtitle-two-sides {
        margin-bottom: 30px
    }

    .btn-flx-addemp, .page-subtitle-two-sides {
        display: flex;
        justify-content: space-between
    }

    .btn-flx-addemp .nhc-btn {
        width: auto
    }

    .btn-flx-addemp .nhc-btn:first-child {
        order: 1;
        -webkit-margin-start: inherit;
        margin-inline-start: inherit
    }

    .btn-flx-addemp .nhc-btn:last-child {
        order: 2;
        -webkit-margin-end: inherit;
        margin-inline-end: inherit
    }

    .btn-flx-addemp.btn-compo-inner {
        margin-top: 60px
    }

    .btn-flx-addemp .btn-flx-group {
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        align-items: flex-end;
        gap: 4px
    }

    .btn-flx-addemp .btn-flx-group-with-dialog {
        display: flex;
        flex-direction: row-reverse;
        justify-content: space-between;
        align-items: flex-end;
        gap: 4px
    }

    .licenseDetailsCard {
        box-shadow: 0 20px 60px 6px rgba(0, 0, 0, .05);
        border-radius: 10px;
        padding: 30px
    }

    .SearchBlockContract #searchBtn .MuiMenu-paper {
        width: 500px !important
    }

    .FormSearchBlock .MuiPopover-paper {
        padding: 16px;
        width: 500px;
        margin-top: 0
    }

    .FormSearchBlock .MuiPopover-paper .mainFormSearch .titleSearch {
        color: #153264;
        margin-bottom: 30px
    }

    .FormSearchBlock .MuiPopover-paper .mainFormSearch .input-group input {
        font-size: 12px
    }

    .twoBtn {
        display: flex;
        justify-content: space-between
    }

    .twoBtn .nhc-btn {
        padding: 0 15px
    }

    .descService {
        font-weight: 400;
        line-height: 32px;
        margin-bottom: 20px
    }

    .copy-link {
        color: #8fceca;
        font-size: 11px;
        -webkit-margin-start: 10px;
        margin-inline-start: 10px
    }

    .parties-contract-block .frist-partie {
        margin-bottom: 30px
    }

    .parties-contract-block .title-parties {
        color: #4d5a61;
        margin-bottom: 15px
    }

    .parties-contract-block .noFoundParties {
        font-weight: 400;
        display: flex;
        align-items: center;
        margin-bottom: 20px
    }

    .parties-contract-block .noFoundParties svg {
        font-weight: 700;
        -webkit-margin-end: 10px;
        margin-inline-end: 10px
    }

    .parties-contract-block .group-card-partie {
        display: flex;
        flex-wrap: wrap;
        margin-bottom: 20px
    }

    .parties-contract-block .card-partie {
        width: calc(30% - 19px);
        background: #fff;
        border: 1px solid #edeff0;
        box-shadow: 1px 2px 6px rgba(0, 0, 0, .05);
        border-radius: 10px;
        padding: 25px 20px;
        margin-bottom: 15px;
        -webkit-margin-end: 15px;
        margin-inline-end: 15px
    }

    .parties-contract-block .card-partie .name-partie {
        margin-bottom: 15px
    }

    .parties-contract-block .card-partie .name-partie.with-delate-partie {
        display: flex;
        justify-content: space-between;
        align-items: center
    }

    .parties-contract-block .card-partie .name-partie.with-delate-partie .delate-partie {
        color: #b72626;
        display: flex;
        align-items: center;
        cursor: pointer
    }

    .parties-contract-block .card-partie .name-partie.with-delate-partie .delate-partie svg {
        -webkit-margin-end: 7px;
        margin-inline-end: 7px
    }

    .parties-contract-block .card-partie .name-partie.with-delate-partie .delate-partie:hover {
        opacity: .9
    }

    .card-auctions-partie {
        width: 90%;
        background: #fff;
        border: 1px solid #edeff0;
        box-shadow: 1px 2px 6px rgba(0, 0, 0, .05);
        border-radius: 10px;
        padding: 25px 20px;
        margin-bottom: 15px;
        -webkit-margin-end: 15px;
        margin-inline-end: 15px
    }

    .card-auctions-partie .name-partie {
        margin-bottom: 15px
    }

    .card-auctions-partie .name-partie.with-delate-partie {
        display: flex;
        justify-content: space-between;
        align-items: center
    }

    .card-auctions-partie .name-partie.with-delate-partie .delate-partie {
        color: #b72626;
        display: flex;
        align-items: center;
        cursor: pointer
    }

    .card-auctions-partie .name-partie.with-delate-partie .delate-partie svg {
        -webkit-margin-end: 7px;
        margin-inline-end: 7px
    }

    .card-auctions-partie .name-partie.with-delate-partie .delate-partie:hover {
        opacity: .9
    }

    .formAddPartie .alertMsg {
        margin-bottom: 40px
    }

    .rangeChooseBlock .titleRangeBlock {
        color: #909a9f;
        font-size: 12px;
        margin-bottom: 15px
    }

    .rangeChooseBlock ul, .rangeChooseBlock ul li {
        display: flex;
        align-items: center
    }

    .rangeChooseBlock ul li {
        transition: all .2s;
        border: 2px solid #edeff0;
        border-radius: 6px;
        color: #153264;
        -webkit-margin-end: 10px;
        margin-inline-end: 10px;
        justify-content: center;
        height: 45px;
        padding: 0 20px;
        cursor: pointer
    }

    .rangeChooseBlock ul li.active, .rangeChooseBlock ul li:hover {
        border: 2px solid #8fceca;
        color: #8fceca
    }

    .rangeChooseBlock ul li:active {
        border: 2px solid #254065;
        color: #254065
    }

    .rangeChooseBlockInner {
        width: 100% !important;
        margin: 0 !important;
        -webkit-margin-end: 0 !important;
        margin-inline-end: 0 !important
    }

    .rangeChooseBlockInner .rangeChooseBlock ul {
        margin-top: 15px !important
    }

    .rangeChooseBlockInnerAutoMargin {
        width: 100% !important;
        -webkit-margin-end: 0 !important;
        margin-inline-end: 0 !important
    }

    .rangeChooseBlockInnerAutoMargin .rangeChooseBlock ul {
        margin-top: 15px !important
    }

    .DatePickerInput input {
        direction: ltr;
        text-align: right
    }

    .MuiPickersArrowSwitcher-root {
        direction: ltr
    }

    .copyTextTooltip {
        background-color: #d3f3d4;
        color: #179f67;
        font-weight: 700;
        font-size: 10px !important;
        padding: 4px 16px
    }

    .hide-step-content {
        display: none
    }

    ::-moz-placeholder {
        color: #bbb;
        opacity: 1
    }

    :-ms-input-placeholder {
        color: #bbb
    }

    ::placeholder {
        color: #bbb
    }

    .text-terms-condition {
        text-align: right;
        font-weight: 400;
        line-height: 26px;
        height: 500px
    }

    .text-terms-condition p {
        padding: 0 35px
    }

    .desc-intro {
        font-weight: 400;
        line-height: 30px;
        color: #101728
    }

    .desc-intro .block-one {
        margin-bottom: 20px
    }

    .desc-intro .title-intro {
        font-weight: 500
    }

    .desc-intro ul {
        list-style-type: disc;
        -webkit-padding-start: 20px;
        padding-inline-start: 20px
    }

    .dataMap {
        display: flex;
        justify-content: space-between
    }

    .dataMap .BlockMap {
        width: 50%
    }

    .dataMap .BlockMap #imap {
        width: 100%;
        height: 500px
    }

    .dataMap .BlockMap #imap .esri-view-surface {
        border-radius: 10px
    }

    .dataMap .FormkMap {
        width: 50%;
        -webkit-padding-start: 50px;
        padding-inline-start: 50px
    }

    .horizontalIcon {
        transform: rotate(270deg)
    }

    .imgAdvInner {
        display: flex;
        flex-wrap: wrap
    }

    .imgAdvInner img {
        border-radius: 10px;
        width: 181px;
        height: 128px;
        -o-object-fit: cover;
        object-fit: cover;
        margin: 10px
    }

    .doneSuccessSteps {
        text-align: center;
        color: #101728
    }

    .doneSuccessSteps .icon-doneSuccess {
        background: url(/_next/static/media/icon-done.26bbfd5d.svg);
        background-repeat: no-repeat;
        background-size: contain;
        height: 115px;
        width: 115px;
        margin: 0 auto 20px
    }

    .doneSuccessSteps .descSuccessDown {
        font-weight: 400;
        margin-top: 15px;
        margin-bottom: 20px
    }

    .doneSuccessSteps .descSuccessDown a {
        color: #8fceca
    }

    .doneSuccessSteps .descSuccessDown a:hover {
        color: #179f67
    }

    .doneSuccessSteps .btnSuccess {
        display: flex;
        justify-content: center;
        margin-top: 30px
    }

    .doneSuccessSteps .btnSuccess .nhc-btn {
        margin: 0 10px
    }

    .desc-list {
        font-size: 13px;
        font-weight: 500;
        line-height: 30px
    }

    .noResult {
        text-align: center;
        color: #4d5a61
    }

    .noResult .iconNoResult {
        background-image: url(/_next/static/media/NoResult.16bb8433.png);
        background-repeat: no-repeat;
        background-size: contain;
        height: 115px;
        width: 115px;
        margin: 0 auto 20px
    }

    .noResult .titleNoResult {
        margin-bottom: 10px
    }

    .noResult .descNoResult {
        font-weight: 400;
        font-size: 12px
    }

    .Ads-logo-image {
        display: none
    }

    .pageAdvPublic .container {
        max-width: 100%;
        padding: 0 50px
    }

    .pageAdvPublic .pageAdvPublicContent {
        padding: 50px;
        position: relative
    }

    .pageAdvPublic .pageAdvPublicContent .title-page-withLink {
        margin-bottom: 50px;
        color: #153264;
        font-size: 17px;
        display: flex;
        justify-items: center
    }

    .pageAdvPublic .pageAdvPublicContent .title-page-withLink a {
        color: #006fb7;
        font-size: 13px;
        display: inline-flex;
        justify-items: center;
        -webkit-margin-start: 30px;
        margin-inline-start: 30px
    }

    .pageAdvPublic .pageAdvPublicContent .title-page-withLink a svg {
        -webkit-margin-end: 7px;
        margin-inline-end: 7px
    }

    .pageAdvPublic .pageAdvPublicContent .title-page-withLink a:hover {
        color: #153264
    }

    .pageAdvPublic .pageAdvPublicContent .authCard {
        display: flex;
        padding: 28px;
        background-color: rgba(214, 236, 246, .2);
        border-radius: 12px
    }

    .pageAdvPublic .pageAdvPublicContent .authCard .iconContainer {
        margin-left: 8px
    }

    .pageAdvPublic .pageAdvPublicContent .authCard .contentContainer .title {
        margin-bottom: 24px;
        font-weight: 700
    }

    .pageAdvPublic .pageAdvPublicContent .authCard .contentContainer .text {
        margin-bottom: 24px;
        font-weight: 400
    }

    .license-container {
        width: 60%;
        margin: 0 auto
    }

    .PageRealState {
        margin-top: 64px
    }

    .inputFormMarketPlace {
        height: -webkit-fill-available;
        border: none;
        border-radius: 8px;
        display: flex;
        justify-content: space-between;
        display: inline-block
    }

    .inputFormMarketPlace:after {
        content: "";
        display: inline-block;
        background: url(/_next/static/media/logout.ac57314a.svg);
        background-repeat: no-repeat;
        background-size: contain;
        width: 23px;
        height: 21px
    }

    .contentPageRealState .contentBanner {
        background: linear-gradient(248.71deg, #153264 1.76%, #00153a 100.34%);
        position: relative;
        z-index: 2;
        color: #fff;
        height: 100%;
        -webkit-padding-start: 60px;
        padding-inline-start: 60px;
        display: flex;
        flex-wrap: wrap;
        height: 100px;
        flex-direction: column;
        justify-content: center;
        margin-bottom: 53px;
        height: 250px;
        border-radius: 8px
    }

    .contentPageRealState .contentBanner h1 {
        margin-bottom: 0
    }

    .contentPageRealState .contentBanner p {
        line-height: 30px;
        font-weight: 400;
        font-size: 17px
    }

    .filtirsFormMarketPlace {
        background-color: #fff;
        height: 100px;
        display: flex;
        justify-content: flex-start;
        margin-left: 63px;
        border-radius: 8px
    }

    .BlockCardCity.bgStyle {
        background-repeat: no-repeat !important;
        background-position: 50% !important;
        background-size: cover !important;
        height: 200px;
        width: auto;
        position: relative;
        border-radius: 10px;
        box-shadow: 0 20px 60px 6px rgba(0, 0, 0, .05);
        margin-bottom: 150px
    }

    .BlockCardCity.bgBannerRiyadhPage {
        background: url(/_next/static/media/bg-real-estate.a04c366b.jpg)
    }

    .BlockCardCity.bgBannerEasternPage {
        background: url(/_next/static/media/king_abdulaziz-center-en\ 1.eb1f94a8.png)
    }

    .BlockCardCity.bgBannerMakkahPage {
        background: url(/_next/static/media/bg-Makkah.8bada24d.png)
    }

    .BlockCardCity .headerCardName {
        position: relative;
        z-index: 2;
        color: #fff;
        height: 100%;
        padding: 0 25px;
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between
    }

    .BlockCardCity .headerCardName a {
        display: flex;
        justify-content: center;
        align-items: center
    }

    .BlockCardCity .headerCardName a svg {
        -webkit-margin-start: 7px;
        margin-inline-start: 7px
    }

    .BlockCardCity .headerCardName a:hover {
        color: #49a09b
    }

    .BlockCardCity .headerCardName .NameCity {
        font-weight: 700;
        font-size: 26px;
        display: flex;
        justify-content: center;
        align-items: center
    }

    .BlockCardCity .CardInfo {
        z-index: 3;
        position: absolute;
        margin-top: -55px;
        width: 96%;
        display: flex;
        justify-content: space-between;
        padding: 0 22px
    }

    .BlockCardCity .CardInfo .MuiCardContent-root {
        padding: 15px
    }

    .BlockCardCity .CardInfo .card-item-mark {
        box-shadow: 1px 2px 6px rgba(0, 0, 0, .05);
        width: 23%;
        position: relative;
        transition: all .3s;
        top: 0
    }

    .BlockCardCity .CardInfo .card-item-mark .block-contectCard {
        display: flex;
        justify-content: space-between;
        align-items: center;
        height: 130px;
        padding: 0 10px
    }

    .BlockCardCity .CardInfo .card-item-mark .numAdv {
        color: #4d5a61;
        font-weight: 700;
        font-size: 10px;
        margin-bottom: 10px
    }

    .BlockCardCity .CardInfo .card-item-mark .numAdv span {
        font-size: 15px;
        font-weight: 700
    }

    .BlockCardCity .CardInfo .card-item-mark .icon-card {
        background: rgba(73, 160, 155, .1);
        border-radius: 4px;
        transform: rotate(-45deg);
        width: 35px;
        height: 35px;
        display: flex;
        align-items: center;
        justify-content: center;
        -webkit-margin-start: 10px;
        margin-inline-start: 10px
    }

    .BlockCardCity .CardInfo .card-item-mark .icon-card svg {
        color: #49a09b;
        transform: rotate(45deg);
        font-size: 22px
    }

    .BlockCardCity .CardInfo .card-item-mark .NameAdv {
        font-weight: 700;
        font-size: 17px;
        color: #101728
    }

    .BlockCardCity .CardInfo .card-item-mark:hover {
        box-shadow: 0 10px 20px 6px rgba(0, 0, 0, .05);
        top: -3px
    }

    .head-page-real {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 40px
    }

    .head-page-real .title-pageReal {
        color: #004f83;
        font-size: 24px
    }

    .head-page-real .filterPage {
        display: flex;
        align-items: center;
        font-size: 15px
    }

    .dataContentPage {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between
    }

    .paginationWrapper {
        margin-bottom: 200px
    }

    .cardReal {
        background: #fff;
        box-shadow: 0 20px 60px 6px rgba(0, 0, 0, .05);
        border-radius: 12px;
        padding: 20px 32px;
        width: calc(50% - 80px);
        margin-bottom: 36px;
        cursor: pointer;
        transition: all .5s
    }

    .cardReal:hover {
        box-shadow: 0 20px 60px 6px rgba(0, 0, 0, .2)
    }

    .cardReal .licenseId {
        color: #4d5a61;
        font-size: 13px
    }

    .cardReal .nameReal {
        color: #101728;
        font-size: 16px;
        margin: 10px 0
    }

    .cardReal .locReal, .cardReal .sizeReal {
        display: flex;
        align-items: center;
        font-weight: 500;
        font-size: 13px;
        margin-bottom: 10px
    }

    .cardReal .locReal span, .cardReal .sizeReal span {
        -webkit-margin-start: 10px;
        margin-inline-start: 10px
    }

    .cardReal .priceReal {
        color: #49a09b;
        font-size: 18px
    }

    .cardReal .resorceRealBlock {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        align-items: center;
        margin-top: 10px
    }

    .cardReal .resorceRealBlock .resorceReal {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        font-size: 13px
    }

    .cardReal .resorceRealBlock .resorceReal img {
        height: 35px;
        margin: 0 10px
    }

    .cardReal .resorceRealBlock .comResorceReal {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        font-size: 13px
    }

    .cardReal .resorceRealBlock .comResorceReal .slogo {
        width: 25px;
        height: 25px;
        background: rgba(143, 206, 202, .2);
        border-radius: 41.6667px;
        color: #8fceca;
        -webkit-margin-end: 10px;
        margin-inline-end: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 11px
    }

    .propertyListingFiltersDialog .MuiDialog-paper {
        width: 800px;
        max-width: 1100px
    }

    .section-title {
        font-size: 16px;
        color: #004f83;
        margin-bottom: 24px
    }

    .section-title .subtitle {
        margin-right: 8px;
        font-size: 14px;
        color: #263238
    }

    .clickable {
        cursor: pointer
    }

    #scrollToHere .btn-search-marketplace {
        width: 150px;
        margin-right: 20px;
        margin-bottom: 15px
    }

    .adPriceTitle {
        color: #254065;
        margin-bottom: 16px
    }

    .menuTitle {
        display: flex;
        align-items: center;
        gap: 15px
    }

    .childList {
        display: flex;
        flex-direction: column
    }

    .child {
        margin-top: 0;
        color: red;
        gap: 0;
        padding: 0;
        display: flex;
        position: relative;
        margin-right: 24px
    }

    .child:before {
        content: "";
        position: absolute;
        border-right: 1px solid hsla(200, 7%, 59%, .4);
        border-bottom: 1px solid hsla(200, 7%, 59%, .4);
        border-bottom-right-radius: 6px;
        top: -30px;
        right: -8px;
        height: 49px;
        width: 8px;
        opacity: 1
    }

    .tap-panel {
        padding: 3px
    }

    .tap-panel .corner-box {
        width: "100%"
    }

    .tap-panel .border-box {
        border-bottom: 1;
        border-color: "divider"
    }

    .tab-span {
        display: flex;
        align-items: center;
        gap: 3px
    }

    .title-with-remove {
        display: flex;
        justify-content: space-between
    }

    .title-with-remove .removeContractParty {
        color: #b72626;
        display: flex;
        align-items: center;
        gap: 18px;
        cursor: pointer;
        font-size: 12px
    }

    .item-accordion {
        padding: 0
    }

    .item-accordion .MuiAccordionSummary-contentGutters {
        margin: 0
    }

    .item-accordion .menuTitle {
        gap: 0
    }

    .ul-listchild {
        padding: 0
    }

    .ul-listchild ul li a {
        width: 100%
    }

    .ul-listchild ul li:first-child:before {
        top: -12px;
        height: 35px
    }

    .generalErrMsg {
        display: block;
        color: #b72626;
        font-size: 10px;
        margin-top: 10px;
        position: absolute
    }

    @media only screen and (max-width: 820px) {
        #register-form {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            padding: 0 15px 50px
        }

        .sidebar-right {
            display: none
        }

        .parties-contract-block .card-partie {
            width: calc(44% - 19px)
        }

        .dataForm .groupItemShow .showData span {
            direction: rtl !important
        }

        .CloseMenu, .MenuIcon {
            padding: 0
        }

        .CloseMenu svg, .MenuIcon svg {
            font-size: 35px;
            color: #006fb7
        }

        .CloseMenu {
            position: absolute;
            left: 20px;
            top: 20px
        }

        .BoxMenuMobileInner {
            width: 100%
        }

        .css-fbde2v-MuiPaper-root-MuiDrawer-paper {
            width: 80%
        }

        .pageAdvPublic .dataForm .groupItemShow {
            width: 33%
        }

        .block-from-group.four-col .input-group {
            width: 45%;
            padding: 6px
        }

        .contentPageRealState .contentBanner {
            padding: 15px;
            flex-wrap: wrap;
            height: auto;
            width: 100%;
            flex-direction: row
        }

        .btn-search-marketplace {
            margin-top: 15px
        }

        .BlockCardCity.bgStyle {
            height: auto;
            padding-top: 15px
        }

        .BlockCardCity .CardInfo {
            position: inherit;
            width: 100%;
            flex-wrap: wrap;
            margin-top: 0;
            padding: 0
        }

        .BlockCardCity .CardInfo .card-item-mark {
            width: calc(50% - 40px);
            margin: 20px
        }
    }

    @media only screen and (max-width: 768px) {
        .sidebar-right {
            display: none
        }
    }

    @media only screen and (max-width: 640px) {
        body, html {
            font-size: 12px !important
        }

        body:after, body:before, html:after, html:before {
            display: none
        }

        #login-form {
            padding: 0 15px
        }

        #login-form, #register-form {
            display: flex;
            justify-content: center;
            flex-wrap: wrap
        }

        #register-form {
            padding: 0 15px 50px
        }

        .btn-prPassword {
            width: auto;
            max-width: 450px
        }

        .blockBeforeLogin {
            border-bottom: 1px solid #ddd;
            padding-bottom: 15px;
            flex-wrap: wrap
        }

        .header .nhc-btn {
            padding: 0 10px;
            font-size: 12px;
            height: 38px
        }

        .header .blockBeforeLogin {
            border-bottom: 1px solid #ddd;
            padding-bottom: 15px;
            flex-wrap: wrap
        }

        .header .blockShowName {
            flex-wrap: wrap
        }

        .header .block-header .testReleaseBadge {
            padding: 8px !important;
            font-size: 8px;
            position: absolute;
            top: 0;
            left: 115px;
            transform: translate(-50%);
            border-radius: 0 0 5px 5px;
            box-shadow: none
        }

        .block-from-group.four-col .input-group, .block-from-group.three-col .input-group, .block-from-group.two-col .input-group {
            width: 100%;
            -webkit-margin-end: 0;
            margin-inline-end: 0
        }

        .block-from-group .form-check {
            align-items: baseline
        }

        .block-from-group .form-check label {
            flex-wrap: wrap;
            width: 100%;
            padding: 10px;
            line-height: 22px
        }

        .block-from-group .form-check button {
            margin-top: 5px
        }

        .data-header-afterLogin {
            flex-wrap: wrap
        }

        .section-content-basepage .main-content {
            padding: 15px
        }

        .dataForm .groupItemShow {
            width: 100%;
            margin-bottom: 20px
        }

        .dataForm .groupItemShow .lableShow, .dataForm .groupItemShow .showData {
            font-size: 11px
        }

        .blockForm .titleBlock {
            font-size: 13px
        }

        .MuiBox-root {
            padding: 0
        }

        .TableNhc .headerItemTbl.rowTabel {
            padding: 20px 0
        }

        .TableNhc .headerItemTbl.rowTabel .colTbl {
            width: 100%;
            margin: 10px 0;
            text-align: right;
            font-size: 11px
        }

        .TableNhc .rowTabel {
            height: auto;
            flex-wrap: wrap
        }

        .TableNhc .rowTabel .colTbl {
            width: 100% !important;
            margin: 10px 0;
            text-align: right !important;
            font-size: 11px
        }

        .TableNhc .rowTabel .actionColBlck {
            width: 100% !important
        }

        .title-inner-page .details-title {
            display: block
        }

        .FormSearchBlock .MuiPopover-paper {
            width: 100%;
            left: 0 !important
        }

        .add-new-licens a, .nhc-btn.btn-full-icon-outline {
            padding: 0 10px;
            font-size: 11px
        }

        .title-inner-page {
            font-size: 14px
        }

        .btn-flx-addemp {
            width: 100%
        }

        .btn-flx-addemp .nhc-btn:last-child {
            -webkit-margin-start: 10px;
            margin-inline-start: 10px
        }

        .title-page {
            font-size: 12px
        }

        .parties-contract-block .group-card-partie {
            display: block
        }

        .parties-contract-block .card-partie {
            width: calc(93% - 19px)
        }

        .alertMsg.alert-warring, .dataMap {
            flex-wrap: wrap
        }

        .dataMap .BlockMap {
            width: 100%
        }

        .dataMap .FormkMap {
            width: 100%;
            padding: 0
        }

        .rangeChooseBlock ul {
            flex-wrap: wrap
        }

        .rangeChooseBlock ul li {
            margin-bottom: 10px
        }

        .pageAdvPublic .pageAdvPublicContent {
            padding: 25px
        }

        .pageAdvPublic .dataForm .groupItemShow {
            width: 100%
        }

        .pageAdvPublic .container {
            max-width: 100%;
            padding: 0 10px
        }

        .license-container {
            width: 80%
        }

        .MenuMobile, .MuiMenu-paper {
            padding: 80px 15px 15px
        }

        .contentPageRealState .bgBannerPage {
            height: 100px
        }

        .contentPageRealState .contentBanner {
            padding: 10px
        }

        .contentPageRealState .contentBanner h1 {
            margin-top: 0;
            margin-bottom: 0;
            font-size: 15px
        }

        .contentPageRealState .contentBanner p {
            line-height: 20px;
            font-size: 9px
        }

        .head-page-real .filterPage, .head-page-real .title-pageReal {
            font-size: 11px
        }

        .cardReal {
            width: 100%;
            padding: 20px
        }

        .cardReal .licenseId, .cardReal .resorceRealBlock .comResorceReal, .cardReal .resorceRealBlock .resorceReal {
            font-size: 10px
        }

        .cardReal .licenseId img, .cardReal .resorceRealBlock .comResorceReal img, .cardReal .resorceRealBlock .resorceReal img {
            height: 25px
        }

        .cardReal .nameReal {
            font-size: 13px
        }

        .cardReal .locReal, .cardReal .sizeReal {
            font-size: 11px
        }

        .cardReal .priceReal {
            font-size: 15px
        }

        .cardReal .resorceRealBlock {
            justify-content: normal;
            align-items: normal;
            flex-direction: column
        }

        .cardReal .resorceRealBlock .comResorceReal {
            margin-top: 10px
        }

        .BlockCardCity .CardInfo .card-item-mark {
            width: 100%
        }

        .contentPageRealState .bgBannerPage.marketPlace {
            height: auto
        }
    }

    @media print {
        body {
            margin: 0;
            padding: 0
        }

        body:after, body:before {
            display: none
        }

        .classIWantToHide {
            display: none !important
        }

        .show-in-print {
            display: block !important
        }

        .dataForm .groupItemShow {
            width: 33%
        }

        .title-page-withLink {
            display: flex;
            justify-content: space-between;
            align-items: center
        }

        .Ads-logo-image {
            text-align: left
        }

        .Ads-logo-image img {
            height: 60px !important
        }
    }

    .Message_genericPopupMessage__FsAgQ .Message_iconMessage__aneUc {
        background-repeat: no-repeat;
        background-size: contain !important;
        height: 120px;
        width: 120px;
        margin: 0 auto 30px
    }

    .Message_genericPopupMessage__FsAgQ .Message_iconMessage__aneUc.Message_success__9O82e {
        background: url(/_next/static/media/icon-done.26bbfd5d.svg)
    }

    .Message_genericPopupMessage__FsAgQ .Message_iconMessage__aneUc.Message_warning__J9WD3 {
        background: url(/_next/static/media/msg-error-register.4980d0b3.svg)
    }

    .Message_genericPopupMessage__FsAgQ .Message_iconMessage__aneUc.Message_error__DhhVx {
        background: url(/_next/static/media/error-circle.8105382d.png)
    }

    .Message_genericPopupMessage__FsAgQ .Message_messageDescription__bEZfi {
        color: #101728;
        text-align: center;
        margin-bottom: 30px;
        line-height: 26px
    }

    .Message_genericPopupMessage__FsAgQ .Message_messageDescription__bEZfi .Message_description__VxsKi {
        font-weight: 400;
        margin-top: 15px
    }

    .public_main__w2a52 {
        background-color: #fff;
        height: 100vh
    }

    @font-face {
        font-family: "29LT Bukra";
        src: url(/_next/static/media/29LTBukra-Medium.504e60cc.eot);
        src: url(/_next/static/media/29LTBukra-Medium.504e60cc.eot) format("embedded-opentype"), url(/_next/static/media/29LTBukra-Medium.86abfa8f.woff2) format("woff2"), url(/_next/static/media/29LTBukra-Medium.db363ffd.woff) format("woff"), url(/_next/static/media/29LTBukra-Medium.8e116ff3.ttf) format("truetype");
        font-weight: 500;
        font-style: normal;
        font-display: swap
    }

    @font-face {
        font-family: "29LT Bukra";
        src: url(/_next/static/media/29LTBukra-Black.a2a30a8d.eot);
        src: url(/_next/static/media/29LTBukra-Black.a2a30a8d.eot) format("embedded-opentype"), url(/_next/static/media/29LTBukra-Black.21978883.woff2) format("woff2"), url(/_next/static/media/29LTBukra-Black.f4ed3dbb.woff) format("woff"), url(/_next/static/media/29LTBukra-Black.295ec7be.ttf) format("truetype");
        font-weight: 900;
        font-style: normal;
        font-display: swap
    }

    @font-face {
        font-family: "29LT Bukra";
        src: url(/_next/static/media/29LTBukra-Light.b08701c9.eot);
        src: url(/_next/static/media/29LTBukra-Light.b08701c9.eot) format("embedded-opentype"), url(/_next/static/media/29LTBukra-Light.fff5788f.woff2) format("woff2"), url(/_next/static/media/29LTBukra-Light.0259c0a4.woff) format("woff"), url(/_next/static/media/29LTBukra-Light.692ad334.ttf) format("truetype");
        font-weight: 300;
        font-style: normal;
        font-display: swap
    }

    @font-face {
        font-family: "29LT Bukra";
        src: url(/_next/static/media/29LTBukra-Bold.c472990d.eot);
        src: url(/_next/static/media/29LTBukra-Bold.c472990d.eot) format("embedded-opentype"), url(/_next/static/media/29LTBukra-Bold.1391157d.woff2) format("woff2"), url(/_next/static/media/29LTBukra-Bold.f48ee15b.woff) format("woff"), url(/_next/static/media/29LTBukra-Bold.c1b41ce4.ttf) format("truetype");
        font-weight: 700;
        font-style: normal;
        font-display: swap
    }

    @font-face {
        font-family: "29LT Bukra";
        src: url(/_next/static/media/29LTBukra-Regular.d6c9965d.eot);
        src: url(/_next/static/media/29LTBukra-Regular.d6c9965d.eot) format("embedded-opentype"), url(/_next/static/media/29LTBukra-Regular.93331525.woff2) format("woff2"), url(/_next/static/media/29LTBukra-Regular.0094c0de.woff) format("woff"), url(/_next/static/media/29LTBukra-Regular.ee22c8f5.ttf) format("truetype");
        font-weight: 400;
        font-style: normal;
        font-display: swap
    }

    .pageAdvPublic * {
        font-family: "29LT Bukra";
        font-size: 14px;
        font-weight: 500;
    }

    .css-vubbuv {
        user-select: none;
        width: 1em;
        height: 1em;
        display: inline-block;
        fill: currentcolor;
        flex-shrink: 0;
        transition: fill 200ms cubic-bezier(0.4, 0, 0.2, 1) 0ms;
        font-size: 1.5rem;
    }
</style>


<div class="ad-view box box-primary">
    <div class="box-header">
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary btn-flat']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger btn-flat',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </div>
    <div class="box-body table-responsive no-padding">
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'id',
                'name',
                'name_en',
                'link',
                [
                    'format' => 'html',
                    'label' => yii::t('app', 'Image'),
                    'attribute' => 'image',
                    'value' => function ($model) {
                        return Html::img($model->image,
                            ['width' => '100px']);
                    },
                ],
                [
                    'attribute' => 'status',
                    'label' => yii::t('app', 'Status'),
                    'value' => function ($model) {
                        return Yii::$app->params['statusCase'][Yii::$app->language][$model->status];
                    }
                ],
                [
                    'attribute' => 'page_name',
                    'value' => function ($model) {
                        return Yii::$app->params['pageName'][Yii::$app->language][$model->page_name];
                    }
                ],
            ],
        ]) ?>
    </div>
</div>

<div class="order-index  box box-primary">

    <?php /* if(yii::$app->user->can('/order/create')){ ?>
        <div class="box-header with-border">
          <?= Html::a(Yii::t('app', 'Create Order'), ['create'], ['class' => 'btn btn-success']) ?>
        </div>
    <?php }*/ ?>

    <div class="pageAdvPublic">
        <div class="pageAdvPublicContent">
            <div class="title-page-withLink ">ترخيص الإعلان العقاري
                <div class="Ads-logo-image show-in-print"><span
                            style="box-sizing: border-box; display: inline-block; overflow: hidden; width: initial; height: initial; background: none; opacity: 1; border: 0px; margin: 0px; padding: 0px; position: relative; max-width: 100%;"><span
                                style="box-sizing: border-box; display: block; width: initial; height: initial; background: none; opacity: 1; border: 0px; margin: 0px; padding: 0px; max-width: 100%;"><img
                                    alt="" aria-hidden="true"
                                    src="data:image/svg+xml,%3csvg%20xmlns=%27http://www.w3.org/2000/svg%27%20version=%271.1%27%20width=%27282%27%20height=%2780%27/%3e"
                                    style="display: block; max-width: 100%; width: initial; height: initial; background: none; opacity: 1; border: 0px; margin: 0px; padding: 0px;"></span><img
                                alt="Logo"
                                src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7"
                                decoding="async" data-nimg="intrinsic"
                                style="position: absolute; inset: 0px; box-sizing: border-box; padding: 0px; border: none; margin: auto; display: block; width: 0px; height: 0px; min-width: 100%; max-width: 100%; min-height: 100%; max-height: 100%;"><noscript></noscript></span>
                </div>
            </div>
            <div class="MainCard_mainCard__2ZwDY">
                <div class="blockForm">
                    <div class="titleBlock"><span>معلومات ترخيص الإعلان </span></div>
                    <div class="dataForm">
                        <div class="groupItemShow">
                            <div class="lableShow">رقم ترخيص الإعلان</div>
                            <div class="showData withText">
                                <svg class="MuiSvgIcon-root MuiSvgIcon-fontSizeMedium css-vubbuv" focusable="false"
                                     aria-hidden="true" viewBox="0 0 24 24" data-testid="TextSnippetOutlinedIcon">
                                    <path d="M14.17 5 19 9.83V19H5V5h9.17m0-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V9.83c0-.53-.21-1.04-.59-1.41l-4.83-4.83c-.37-.38-.88-.59-1.41-.59zM7 15h10v2H7v-2zm0-4h10v2H7v-2zm0-4h7v2H7V7z"></path>
                                </svg>
                                <?= $model->adLicenseNumber ?>
                            </div>
                        </div>

                        <div class="groupItemShow">
                            <div class="lableShow">تاريخ إصدار الإعلان</div>
                            <div class="showData">
                                <svg class="MuiSvgIcon-root MuiSvgIcon-fontSizeMedium css-vubbuv" focusable="false"
                                     aria-hidden="true" viewBox="0 0 24 24" data-testid="CalendarTodayOutlinedIcon">
                                    <path d="M20 3h-1V1h-2v2H7V1H5v2H4c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 18H4V10h16v11zm0-13H4V5h16v3z"></path>
                                </svg>

                                <?= $takamolat->result->advertisement->creationDate ?>
                            </div>
                        </div>

                        <div class="groupItemShow">
                            <div class="lableShow">تاريخ انتهاء رخصة الإعلان</div>

                            <div class="showData">
                                <svg class="MuiSvgIcon-root MuiSvgIcon-fontSizeMedium css-vubbuv" focusable="false"
                                     aria-hidden="true" viewBox="0 0 24 24" data-testid="CalendarTodayOutlinedIcon">
                                    <path d="M20 3h-1V1h-2v2H7V1H5v2H4c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 18H4V10h16v11zm0-13H4V5h16v3z"></path>
                                </svg>
                                <?= $takamolat->result->advertisement->endDate ?>
                            </div>
                        </div>
                        <div class="groupItemShow">
                            <div class="lableShow">غرض الإعلان</div>
                            <div class="showData">
                                <svg class="MuiSvgIcon-root MuiSvgIcon-fontSizeMedium css-vubbuv" focusable="false"
                                     aria-hidden="true" viewBox="0 0 24 24" data-testid="CalendarTodayOutlinedIcon">
                                    <path d="M20 3h-1V1h-2v2H7V1H5v2H4c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 18H4V10h16v11zm0-13H4V5h16v3z"></path>
                                </svg>

                                <?= $takamolat?->result?->advertisement?->advertisementType ?>
                            </div>
                        </div>

                        <div class="groupItemShow">
                            <div class="lableShow">اسم المعلن</div>
                            <div class="showData">
                                <svg class="MuiSvgIcon-root MuiSvgIcon-fontSizeMedium css-vubbuv" focusable="false"
                                     aria-hidden="true" viewBox="0 0 24 24" data-testid="TextSnippetOutlinedIcon">
                                    <path d="M14.17 5 19 9.83V19H5V5h9.17m0-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V9.83c0-.53-.21-1.04-.59-1.41l-4.83-4.83c-.37-.38-.88-.59-1.41-.59zM7 15h10v2H7v-2zm0-4h10v2H7v-2zm0-4h7v2H7V7z"></path>
                                </svg>

                                <?= $takamolat?->result?->advertisement?->advertiserName ?>

                            </div>
                        </div>

                        <div class="groupItemShow">
                            <div class="lableShow">رقم رخصة فال للوساطة والتسويق العقاري</div>
                            <div class="showData">
                                <svg class="MuiSvgIcon-root MuiSvgIcon-fontSizeMedium css-vubbuv" focusable="false"
                                     aria-hidden="true" viewBox="0 0 24 24" data-testid="WorkspacePremiumOutlinedIcon">
                                    <path d="M9.68 13.69 12 11.93l2.31 1.76-.88-2.85L15.75 9h-2.84L12 6.19 11.09 9H8.25l2.31 1.84-.88 2.85zM20 10c0-4.42-3.58-8-8-8s-8 3.58-8 8c0 2.03.76 3.87 2 5.28V23l6-2 6 2v-7.72c1.24-1.41 2-3.25 2-5.28zm-8-6c3.31 0 6 2.69 6 6s-2.69 6-6 6-6-2.69-6-6 2.69-6 6-6zm0 15-4 1.02v-3.1c1.18.68 2.54 1.08 4 1.08s2.82-.4 4-1.08v3.1L12 19z"></path>
                                </svg>

                                <?= $takamolat?->result?->advertisement?->advertiserId ?>

                            </div>
                        </div>

                        <div class="groupItemShow">
                            <div class="lableShow">سعر الوحدة</div>
                            <div class="showData">
                                <svg class="MuiSvgIcon-root MuiSvgIcon-fontSizeMedium css-vubbuv" focusable="false"
                                     aria-hidden="true" viewBox="0 0 24 24" data-testid="BusinessOutlinedIcon">
                                    <path d="M12 7V3H2v18h20V7H12zM6 19H4v-2h2v2zm0-4H4v-2h2v2zm0-4H4V9h2v2zm0-4H4V5h2v2zm4 12H8v-2h2v2zm0-4H8v-2h2v2zm0-4H8V9h2v2zm0-4H8V5h2v2zm10 12h-8v-2h2v-2h-2v-2h2v-2h-2V9h8v10zm-2-8h-2v2h2v-2zm0 4h-2v2h2v-2z"></path>
                                </svg>

                                <?= $takamolat?->result?->advertisement?->propertyPrice ?>

                            </div>
                        </div>

                        <div class="groupItemShow">
                            <div class="lableShow">قنوات الإعلان</div>

                            <div class="showData">
                                <svg class="MuiSvgIcon-root MuiSvgIcon-fontSizeMedium css-vubbuv" focusable="false"
                                     aria-hidden="true" viewBox="0 0 24 24" data-testid="CampaignOutlinedIcon">
                                    <path d="M18 11v2h4v-2h-4zm-2 6.61c.96.71 2.21 1.65 3.2 2.39.4-.53.8-1.07 1.2-1.6-.99-.74-2.24-1.68-3.2-2.4-.4.54-.8 1.08-1.2 1.61zM20.4 5.6c-.4-.53-.8-1.07-1.2-1.6-.99.74-2.24 1.68-3.2 2.4.4.53.8 1.07 1.2 1.6.96-.72 2.21-1.65 3.2-2.4zM4 9c-1.1 0-2 .9-2 2v2c0 1.1.9 2 2 2h1v4h2v-4h1l5 3V6L8 9H4zm5.03 1.71L11 9.53v4.94l-1.97-1.18-.48-.29H4v-2h4.55l.48-.29zM15.5 12c0-1.33-.58-2.53-1.5-3.35v6.69c.92-.81 1.5-2.01 1.5-3.34z"></path>
                                </svg>

                                <?= $takamolat?->result?->advertisement?->channels[0] ?>
                            </div>
                        </div>

                        <div class="groupItemShow">
                            <div class="lableShow">رمز الإستجابة السريعة</div>

                            <div class="AdQr_adQrImageContainer__80TBW" id="adQrImageContainer">
                                <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=<?= $takamolat?->result?->advertisement?->qrCodeUrl ?>" alt="" />

                                <div class="AdQr_adQrText__oPLm8">
                                    <span>
                                        <span class="AdQr_adQrTextBiggerWord__iMCMt">
                                            <?php
                                            echo match($takamolat?->result?->isValid) {
                                                true => 'نشط',
                                                default => 'غير نشط'
                                            };
                                            ?>
                                        </span>

                                        #<?= $takamolat->result->advertisement->adLicenseNumber?>
                                    </span>

                                    <span>ينتهي بتاريخ

                                        <span id="endDateText" style="margin-right: 4px;"><?= $takamolat->result->advertisement->endDate?></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="groupItemShow">
                            <div class="lableShow">قناة ترخيص الإعلان</div>
                            <div>
                                <span style="box-sizing: border-box; display: inline-block; overflow: hidden; width: initial; height: initial; background: none; opacity: 1; border: 0px; margin: 0px; padding: 0px; position: relative; max-width: 100%;"><span
                                            style="box-sizing: border-box; display: block; width: initial; height: initial; background: none; opacity: 1; border: 0px; margin: 0px; padding: 0px; max-width: 100%;"><img
                                                alt="" aria-hidden="true"
                                                src="data:image/svg+xml,%3csvg%20xmlns=%27http://www.w3.org/2000/svg%27%20version=%271.1%27%20width=%27141%27%20height=%2740%27/%3e"
                                                style="display: block; max-width: 100%; width: initial; height: initial; background: none; opacity: 1; border: 0px; margin: 0px; padding: 0px;"></span><img
                                            alt="Logo"
                                            src="https://eservicesredp.rega.gov.sa/_next/image?url=%2F_next%2Fstatic%2Fmedia%2Flogo.efa0062e.png&w=384&q=75"
                                            decoding="async" data-nimg="intrinsic" class="showData"
                                            style="position: absolute; inset: 0px; box-sizing: border-box; padding: 0px; border: none; margin: auto; display: block; width: 0px; height: 0px; min-width: 100%; max-width: 100%; min-height: 100%; max-height: 100%;"
                                            srcset="https://eservicesredp.rega.gov.sa/_next/image?url=%2F_next%2Fstatic%2Fmedia%2Flogo.efa0062e.png&w=384&q=75"><noscript></noscript></span>
                            </div>
                        </div>
                        <div class="groupItemShow">
                            <div class="lableShow">حالة الإعلان</div>
                            <div class="showData">
                                <div class="statusNhc statusSuccess">
                                    <?php
                                    echo match($takamolat?->result?->isValid) {
                                        true => 'نشط',
                                        default => 'غير نشط'
                                    };
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="blockForm">
                    <div class="titleBlock"><span>معلومات العقار </span></div>
                    <div class="dataForm">
                        <div class="groupItemShow">
                            <div class="lableShow">نوع العقار</div>
                            <div class="showData">
                                <svg class="MuiSvgIcon-root MuiSvgIcon-fontSizeMedium css-vubbuv" focusable="false"
                                     aria-hidden="true" viewBox="0 0 24 24" data-testid="ApartmentOutlinedIcon">
                                    <path d="M17 11V3H7v4H3v14h8v-4h2v4h8V11h-4zM7 19H5v-2h2v2zm0-4H5v-2h2v2zm0-4H5V9h2v2zm4 4H9v-2h2v2zm0-4H9V9h2v2zm0-4H9V5h2v2zm4 8h-2v-2h2v2zm0-4h-2V9h2v2zm0-4h-2V5h2v2zm4 12h-2v-2h2v2zm0-4h-2v-2h2v2z"></path>
                                </svg>

                                <?= $takamolat?->result?->advertisement?->propertyType ?>

                            </div>
                        </div>
                        <div class="groupItemShow">
                            <div class="lableShow">استخدام العقار</div>
                            <div class="showData">
                                <svg class="MuiSvgIcon-root MuiSvgIcon-fontSizeMedium css-vubbuv" focusable="false"
                                     aria-hidden="true" viewBox="0 0 24 24" data-testid="ApartmentOutlinedIcon">
                                    <path d="M17 11V3H7v4H3v14h8v-4h2v4h8V11h-4zM7 19H5v-2h2v2zm0-4H5v-2h2v2zm0-4H5V9h2v2zm4 4H9v-2h2v2zm0-4H9V9h2v2zm0-4H9V5h2v2zm4 8h-2v-2h2v2zm0-4h-2V9h2v2zm0-4h-2V5h2v2zm4 12h-2v-2h2v2zm0-4h-2v-2h2v2z"></path>
                                </svg>

                                <?= $takamolat?->result?->advertisement?->propertyUsages[0] ?>

                            </div>
                        </div>

                        <div class="groupItemShow">
                            <div class="lableShow">مساحة العقار</div>
                            <div class="showData">
                                <svg class="MuiSvgIcon-root MuiSvgIcon-fontSizeMedium css-vubbuv" focusable="false"
                                     aria-hidden="true" viewBox="0 0 24 24" data-testid="SwapHorizOutlinedIcon">
                                    <path d="M6.99 11 3 15l3.99 4v-3H14v-2H6.99v-3zM21 9l-3.99-4v3H10v2h7.01v3L21 9z"></path>
                                </svg>
                                <?= $takamolat?->result?->advertisement?->propertyArea ?>

                            </div>
                        </div>
                        <div class="groupItemShow">
                            <div class="lableShow">عرض الشارع</div>
                            <div class="showData">
                                <svg class="MuiSvgIcon-root MuiSvgIcon-fontSizeMedium css-vubbuv" focusable="false"
                                     aria-hidden="true" viewBox="0 0 24 24" data-testid="SwapHorizOutlinedIcon">
                                    <path d="M6.99 11 3 15l3.99 4v-3H14v-2H6.99v-3zM21 9l-3.99-4v3H10v2h7.01v3L21 9z"></path>
                                </svg>

                                <?= $takamolat?->result?->advertisement?->streetWidth ?>
                            </div>
                        </div>
                        <div class="groupItemShow">
                            <div class="lableShow">رقم المخطط</div>
                            <div class="showData">
                                <svg class="MuiSvgIcon-root MuiSvgIcon-fontSizeMedium css-vubbuv" focusable="false"
                                     aria-hidden="true" viewBox="0 0 24 24" data-testid="SignpostOutlinedIcon">
                                    <path d="M13 10h5l3-3-3-3h-5V2h-2v2H4v6h7v2H6l-3 3 3 3h5v4h2v-4h7v-6h-7v-2zM6 6h11.17l1 1-1 1H6V6zm12 10H6.83l-1-1 1-1H18v2z"></path>
                                </svg>

                                <?= $takamolat?->result?->advertisement?->planNumber ?>
                            </div>
                        </div>
                        <div class="groupItemShow">
                            <div class="lableShow">واجهة العقار</div>
                            <div class="showData">
                                <svg class="MuiSvgIcon-root MuiSvgIcon-fontSizeMedium css-vubbuv" focusable="false"
                                     aria-hidden="true" viewBox="0 0 24 24" data-testid="ApartmentOutlinedIcon">
                                    <path d="M17 11V3H7v4H3v14h8v-4h2v4h8V11h-4zM7 19H5v-2h2v2zm0-4H5v-2h2v2zm0-4H5V9h2v2zm4 4H9v-2h2v2zm0-4H9V9h2v2zm0-4H9V5h2v2zm4 8h-2v-2h2v2zm0-4h-2V9h2v2zm0-4h-2V5h2v2zm4 12h-2v-2h2v2zm0-4h-2v-2h2v2z"></path>
                                </svg>

                                <?= $takamolat?->result?->advertisement?->propertyFace ?>
                            </div>
                        </div>

                        <div class="groupItemShow">
                            <div class="lableShow">خدمات العقار</div>
                            <div class="showData">
                                <svg class="MuiSvgIcon-root MuiSvgIcon-fontSizeMedium css-vubbuv" focusable="false"
                                     aria-hidden="true" viewBox="0 0 24 24" data-testid="ApartmentOutlinedIcon">
                                    <path d="M17 11V3H7v4H3v14h8v-4h2v4h8V11h-4zM7 19H5v-2h2v2zm0-4H5v-2h2v2zm0-4H5V9h2v2zm4 4H9v-2h2v2zm0-4H9V9h2v2zm0-4H9V5h2v2zm4 8h-2v-2h2v2zm0-4h-2V9h2v2zm0-4h-2V5h2v2zm4 12h-2v-2h2v2zm0-4h-2v-2h2v2z"></path>
                                </svg>
                                <!--                                كهرباء, مياه, صرف صحي-->

                                <?php
                                $services = $takamolat?->result?->advertisement?->propertyUtilities;

                                echo implode(', ', $services);
                                ?>
                            </div>
                        </div>
                        <div class="groupItemShow">
                            <div class="lableShow">عمر العقار</div>
                            <div class="showData">
                                <svg class="MuiSvgIcon-root MuiSvgIcon-fontSizeMedium css-vubbuv" focusable="false"
                                     aria-hidden="true" viewBox="0 0 24 24" data-testid="CalendarTodayOutlinedIcon">
                                    <path d="M20 3h-1V1h-2v2H7V1H5v2H4c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 18H4V10h16v11zm0-13H4V5h16v3z"></path>
                                </svg>

                                <?= $takamolat?->result?->advertisement?->propertyAge ?>
                            </div>
                        </div>

                        <div class="groupItemShow">
                            <div class="lableShow">عدد الغرف</div>
                            <div class="showData">
                                <svg class="MuiSvgIcon-root MuiSvgIcon-fontSizeMedium css-vubbuv" focusable="false"
                                     aria-hidden="true" viewBox="0 0 24 24" data-testid="ApartmentOutlinedIcon">
                                    <path d="M17 11V3H7v4H3v14h8v-4h2v4h8V11h-4zM7 19H5v-2h2v2zm0-4H5v-2h2v2zm0-4H5V9h2v2zm4 4H9v-2h2v2zm0-4H9V9h2v2zm0-4H9V5h2v2zm4 8h-2v-2h2v2zm0-4h-2V9h2v2zm0-4h-2V5h2v2zm4 12h-2v-2h2v2zm0-4h-2v-2h2v2z"></path>
                                </svg>
                                <?= $takamolat?->result?->advertisement?->numberOfRooms ?>
                            </div>
                        </div>
                        <div class="groupItemShow">
                            <div class="lableShow">مطابقة كود البناء السعودي</div>

                            <div class="showData">
                                <svg class="MuiSvgIcon-root MuiSvgIcon-fontSizeMedium css-vubbuv" focusable="false"
                                     aria-hidden="true" viewBox="0 0 24 24" data-testid="ApartmentOutlinedIcon">
                                    <path d="M17 11V3H7v4H3v14h8v-4h2v4h8V11h-4zM7 19H5v-2h2v2zm0-4H5v-2h2v2zm0-4H5V9h2v2zm4 4H9v-2h2v2zm0-4H9V9h2v2zm0-4H9V5h2v2zm4 8h-2v-2h2v2zm0-4h-2V9h2v2zm0-4h-2V5h2v2zm4 12h-2v-2h2v2zm0-4h-2v-2h2v2z"></path>
                                </svg>

                                <?php
                                echo match ($takamolat?->result?->advertisement?->complianceWithTheSaudiBuildingCode) {
                                    'true' => 'مطابق',
                                    default => 'غير مطابق',
                                };
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="dataForm">
                        <div class="groupItemShow">
                            <div class="lableShow">حدود وأطوال العقار</div>
                            <div class="showData"><?= $takamolat?->result?->advertisement?->theBordersAndLengthsOfTheProperty ?></div>
                        </div>
                        <div class="groupItemShow">
                            <div class="lableShow">الضمانات ومدتها</div>
                            <div class="showData"><?= $takamolat?->result?->advertisement?->guaranteesAndTheirDuration ?></div>
                        </div>
                        <div class="groupItemShow">
                            <div class="lableShow">الالتزامات الآخرى على العقار</div>
                            <div class="showData"><?= $takamolat?->result?->advertisement?->obligationsOnTheProperty ?></div>
                        </div>
                    </div>
                </div>
                <div class="blockForm">
                    <div class="titleBlock"><span>عنوان العقار </span></div>

                    <div class="dataForm">
                        <div class="groupItemShow">
                            <div class="lableShow">المنطقة</div>
                            <div class="showData">
                                <svg class="MuiSvgIcon-root MuiSvgIcon-fontSizeMedium css-vubbuv" focusable="false"
                                     aria-hidden="true" viewBox="0 0 24 24" data-testid="LocationOnOutlinedIcon">
                                    <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zM7 9c0-2.76 2.24-5 5-5s5 2.24 5 5c0 2.88-2.88 7.19-5 9.88C9.92 16.21 7 11.85 7 9z"></path>
                                    <circle cx="12" cy="9" r="2.5"></circle>
                                </svg>

                                <?= $takamolat?->result?->advertisement?->location?->region ?>
                            </div>
                        </div>
                        <div class="groupItemShow">
                            <div class="lableShow">المدينة</div>
                            <div class="showData">
                                <svg class="MuiSvgIcon-root MuiSvgIcon-fontSizeMedium css-vubbuv" focusable="false"
                                     aria-hidden="true" viewBox="0 0 24 24" data-testid="LocationOnOutlinedIcon">
                                    <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zM7 9c0-2.76 2.24-5 5-5s5 2.24 5 5c0 2.88-2.88 7.19-5 9.88C9.92 16.21 7 11.85 7 9z"></path>
                                    <circle cx="12" cy="9" r="2.5"></circle>
                                </svg>

                                <?= $takamolat?->result?->advertisement?->location?->city ?>
                            </div>
                        </div>
                        <div class="groupItemShow">
                            <div class="lableShow">الحي</div>
                            <div class="showData">
                                <svg class="MuiSvgIcon-root MuiSvgIcon-fontSizeMedium css-vubbuv" focusable="false"
                                     aria-hidden="true" viewBox="0 0 24 24" data-testid="LocationOnOutlinedIcon">
                                    <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zM7 9c0-2.76 2.24-5 5-5s5 2.24 5 5c0 2.88-2.88 7.19-5 9.88C9.92 16.21 7 11.85 7 9z"></path>
                                    <circle cx="12" cy="9" r="2.5"></circle>
                                </svg>

                                <?= $takamolat?->result?->advertisement?->location?->district ?>
                            </div>
                        </div>
                        <div class="groupItemShow">
                            <div class="lableShow">الشارع</div>
                            <div class="showData">
                                <svg class="MuiSvgIcon-root MuiSvgIcon-fontSizeMedium css-vubbuv" focusable="false"
                                     aria-hidden="true" viewBox="0 0 24 24" data-testid="LocationOnOutlinedIcon">
                                    <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zM7 9c0-2.76 2.24-5 5-5s5 2.24 5 5c0 2.88-2.88 7.19-5 9.88C9.92 16.21 7 11.85 7 9z"></path>
                                    <circle cx="12" cy="9" r="2.5"></circle>
                                </svg>

                                <?= $takamolat?->result?->advertisement?->location?->street ?>
                            </div>
                        </div>
                        <div class="groupItemShow">
                            <div class="lableShow">الرمز البريدي</div>
                            <div class="showData">
                                <svg class="MuiSvgIcon-root MuiSvgIcon-fontSizeMedium css-vubbuv" focusable="false"
                                     aria-hidden="true" viewBox="0 0 24 24" data-testid="FmdGoodOutlinedIcon">
                                    <path d="M12 12c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm6-1.8C18 6.57 15.35 4 12 4s-6 2.57-6 6.2c0 2.34 1.95 5.44 6 9.14 4.05-3.7 6-6.8 6-9.14zM12 2c4.2 0 8 3.22 8 8.2 0 3.32-2.67 7.25-8 11.8-5.33-4.55-8-8.48-8-11.8C4 5.22 7.8 2 12 2z"></path>
                                </svg>
                                <?= $takamolat?->result?->advertisement?->location?->postalCode ?>
                            </div>
                        </div>
                        <div class="groupItemShow">
                            <div class="lableShow">رقم المبنى</div>
                            <div class="showData">
                                <svg class="MuiSvgIcon-root MuiSvgIcon-fontSizeMedium css-vubbuv" focusable="false"
                                     aria-hidden="true" viewBox="0 0 24 24" data-testid="FmdGoodOutlinedIcon">
                                    <path d="M12 12c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm6-1.8C18 6.57 15.35 4 12 4s-6 2.57-6 6.2c0 2.34 1.95 5.44 6 9.14 4.05-3.7 6-6.8 6-9.14zM12 2c4.2 0 8 3.22 8 8.2 0 3.32-2.67 7.25-8 11.8-5.33-4.55-8-8.48-8-11.8C4 5.22 7.8 2 12 2z"></path>
                                </svg>

                                <?= $takamolat?->result?->advertisement?->location?->buildingNumber ?>
                            </div>
                        </div>
                        <div class="groupItemShow">
                            <div class="lableShow">الرمز الإضافي</div>
                            <div class="showData">
                                <svg class="MuiSvgIcon-root MuiSvgIcon-fontSizeMedium css-vubbuv" focusable="false"
                                     aria-hidden="true" viewBox="0 0 24 24" data-testid="FmdGoodOutlinedIcon">
                                    <path d="M12 12c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm6-1.8C18 6.57 15.35 4 12 4s-6 2.57-6 6.2c0 2.34 1.95 5.44 6 9.14 4.05-3.7 6-6.8 6-9.14zM12 2c4.2 0 8 3.22 8 8.2 0 3.32-2.67 7.25-8 11.8-5.33-4.55-8-8.48-8-11.8C4 5.22 7.8 2 12 2z"></path>
                                </svg>

                                <?= $takamolat?->result?->advertisement?->location?->additionalNumber ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>