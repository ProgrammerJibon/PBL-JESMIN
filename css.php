<?php header("content-type: text/css"); ?>
/*<style type="text/css">/**/
*{
    box-sizing: border-box;
    /* user-select: none; */
    pointer-events: visible;
}
:root {
    --primary: #753275;
    --secondary1: #222222;
    --secondary2: #ededed;
    --navbarHeight: 100px;
}
::-webkit-calendar-picker-indicator {
    /* filter: invert(1); */
    cursor: pointer;
}
::-webkit-scrollbar {
    width: 5px;
    height: 5px;
}
::-webkit-scrollbar-track {
    box-shadow: inset -1px -1px 10px -5px #fff;
    border-radius: 0px;
}
::-webkit-scrollbar-thumb {
    background: #c3c3c3;
    border-radius: 6px;
}
::-webkit-scrollbar-thumb:hover {
  background: #b30000; 
}
html{
    scroll-behavior: smooth;
}
body{
    background-color: var(--primary);
    margin: 0;
    font-family: sans-serif;
    /* margin-top: 60px; */
    line-height: unset !important;
}
button:disabled, select:disabled {
    background: #8f778f !important;
    color: black;
    cursor: no-drop !important;
}
li{
    list-style: none;
    font-size: unset !important;
}
img{
    width: 100%;
    height: 100%;
    object-fit: contain;
    cursor: none;
    pointer-events: none;
}
span, h1, h4{
    cursor: text;
}

.nav-flex {
    display: flex;
    justify-content: space-between;
    background: #0e0e0e;
    align-content: center;
    align-items: center;
    flex-direction: row;
}



/* all flex system */
.flex-between{
    display: flex;
    justify-content: space-between;
}
.flex-only{
    display: flex;
}
.flex-item {
    color: var(--primary);
    font-size: 14px;
    padding: 16px;
    text-decoration: none;
    font-weight: bold;
    display: inline-block;
    text-transform: uppercase;
    text-align: center;
    border: none;
    cursor: pointer;
}
a.flex-item:hover{
    background: #ffffff17;
}
.flex {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-direction: row;
    flex-wrap: nowrap;
    align-content: center;
}

.error {
			color: red;
			font-family: monospace;
			padding: 8px;
		}



/* navbar */

.navbar-container{
    position: sticky;
    left: 0;
    right: 0;
    top: 0;
    z-index: 999;
    background-color: var(--primary);
    box-shadow: 0px 5px 10px -5px rgb(100 30 100);
    border-bottom: 1px solid rgb(100 30 100);
}

.navbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    height: var(--navbarHeight);
    padding: 10px;
    max-width: 1132px;
    margin: 0 auto;
}

.logo img {
  height: 40px;
  width: auto;
}

.nav-menus ul {
    list-style-type: none;
    padding: 0;
    margin: 0;
    display: flex;
    flex-direction: row;
    flex-wrap: wrap;
    justify-content: center;
    align-items: center;
    align-content: center;
}

.nav-menus ul li {
  display: inline-block;
  margin: 0px 16px;
}

.navbar a {
  text-decoration: none;
  display: inline-block;
  color: white;
}
.navbar a:hover {
  text-decoration: underline;
}
.navbar a:active {
  text-decoration: none;
  color: red;
}

.user-account {
    position: relative;
    height: 100%;
}

.dropdown {
    display: inline-block;
    height: 100%;
}

.dropbtn {
    border: none;
    height: 100%;
    cursor: pointer;
    background: none;
    color: white;
    font-weight: bold;
    text-transform: uppercase;
    font-family: system-ui;
}

.dropdown-content {
  display: none;
  position: absolute;
  background-color: #f9f9f9;
  min-width: 120px;
  box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
  z-index: 1;
  right: 0;
}

.dropdown-content a {
  padding: 12px 16px;
  text-decoration: none;
  display: block;
  color: var(--primary);
  width: max-content;
}

.dropdown:hover .dropdown-content {
  display: block;
}




/* events page */


.add-btn {
    margin: 32px 16px;
    display: block;
    margin-left: auto;
    padding: 12px 24px;
    font-size: 14px;
    font-weight: bold;
    text-align: center;
    text-transform: uppercase;
    color: var(--secondary1);
    background-color: var(--primary);
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}
.add-btn:hover {
        background-color: #0069d9;
      }



      /* preview image of input */
.previewImage img {
    width: 100%;
    object-fit: cover;
}
.previewImage {
    width: 100%;
}

img[src=""]:empty {
  display: none;
}


.tableContainer {
    padding: 8px;
}
.tdLink{
    cursor: pointer;
    text-decoration: underline;
}

.trLink{
    cursor: pointer;
}

table {
    flex: 1 1 70%;
    background: #ffffff;
    padding: 8px;
    border-radius: 6px;
    box-shadow: 5px 5px 15px -10px rgb(0 0 0);
    border: 1px solid #e1e1e1;
    border-collapse: separate;
}

tr {
    background-color: #d5d5d5;
    color: #585858;
    padding: 10px;
    /* border-radius: 6px; */
    margin: 16px;
    /* box-shadow: 5px 5px 10px -5px #000000; */
    border: 1px solid #2e2e2e;
    font-size: 14px;
    font-family: sans-serif;
}
tr:nth-child(even) {
    background-color: #efefef;
}
tr .title {
    font-weight: lighter;
    margin-right: 8px;
    margin-top: 8px;
    display: inline-block;
    text-decoration: underline dotted;
}
tr .bold{
    font-weight: bold;
}
tr .main_title{
    margin-top: 8px;
    display: inline-block;
    font-weight: bold;
}
td, th {
    padding: 8px;
}
tr:hover{
    box-shadow: inset 5px 5px 15px -12px #000000;
    border: 1px solid #2e2e2e;
}
thead tr:hover{
    box-shadow: none;
    border: none;
}
tr:hover *{
    user-select: none;
}

.eventDetails {
    position: sticky;
    background: #ffffff;
    height: 70vh;
    margin: 5vh;
    border-radius: 6px;
    box-shadow: 5px 5px 10px 0px #dfdfdf;
    border: 1px solid #ffdcca;
    padding: 16px;
    flex: 1 1 40%;
    overflow-y: scroll;
}


/* For Webkit browsers */
.eventDetails::-webkit-scrollbar {
  width: 5px;
}

.eventDetails::-webkit-scrollbar-thumb {
  background-color: #ffdccb;
  border-radius: 5px;
}

.eventDetails::-webkit-scrollbar-thumb:hover {
  background-color: #555;
}



.eventInfo {
    color: #464646;
    margin: 8px;
    font-size: 14px;
}

.eventInfo.eventHeader {
    text-align: left;
    font-weight: bold;
    font-size: 16px;
}


.eventInfo.eventTitle {
    text-transform: capitalize;
    color: #ff6517;
    font-size: 20px;
    font-family: fantasy;
    font-weight: lighter;
    letter-spacing: 1px;
}

.dataContainer.eventInfo {
    font-size: 12px;
}

span.dataTitle {
    margin-right: 8px;
}

span.dataSet {
    font-weight: bold;
    display: inline-block;
}

img.protectBackgroundPng{
    background: #d9d9d9;
}


button.actionButton.btnSuccess {
    background-color: #4caf50;
    border: 1px solid #4caf50;
    color: #fff;
    font-weight: bold;
}

button.actionButton.btnWarning {
    background-color: #ffc107;
    border: 1px solid #ffc107;
    color: #fff;
    font-weight: bold;
}

button.actionButton.btnError {
    background-color: #f44336;
    border: 1px solid #f44336;
    color: #fff;
    font-weight: bold;
}

button.actionButton {
    padding: 8px 16px;
    border: 1px solid #cbcbcb;
    border-radius: 2px;
}
button.actionButton:hover{
    background: white;
    cursor: pointer;
    border: 1px solid #ff6517;
    color: #ff6517;
}

Description {
    display: block;
    font-weight: lighter;
    font-family: cursive;
    color: gray;
    padding: 8px;
}
td.avatar img {
    width: 150px;
    height: 150px;
}
td.nid img {
    width: 300px;
    height: 150px;
    object-fit: contain;
}
.details {
    text-align: left;
}
.details .value{
    font-weight: bold;
}
.actionBtns .actionButton{
    margin: 2px;
}








/*generate qr*/
.containerHome {
    /* display: flex; */
    max-width: 1132px;
    margin: 0 auto;
    padding: 24px 0 64px 0;
    position: relative;
}

/* .columnL {
    max-width: 25%;
    flex: 25%;
    background: white;
    height: calc(100vh - var(--navbarHeight));
    overflow-y: scroll;
} */
.qrGeneratorContainer {
    display: flex;
    flex-direction: row;
    flex-wrap: wrap;
    align-items: stretch;
    border-radius: 6px;
    overflow: hidden;
}
.columnM {
    flex: 60%;
    background-color: var(--secondary2);
    min-height: 100vh;
    padding: 32px 0px;
    /* flex: 50%; */
    /* overflow-y: scroll; */
    /* height: calc(100vh - var(--navbarHeight)); */
}

.columnM img{
    width: 100%;
}

.columnR {
    flex: 40%;
    background-color: #f1e1f1;
    min-height: 100vh;
    padding: 32px 0px;
}

.links_of_qr_title {
    list-style-type: none;
    padding: 0;
    margin: 0;
    display: flex;
    flex-direction: row;
    align-content: center;
    align-items: stretch;
    justify-content: space-between;
    margin: 0 32px;
}
a{
    color: #fff700;;
}
.links_of_qr_title li a,
.moreQrGenMoreBtn {
    text-decoration: none;
    padding: 4px 10px;
    border-bottom: 3px solid transparent;
    height: 100%;
    display: flex;
    /* color: #247f4f; */
    color: white;
    opacity: 0.7;
    align-items: center;
    justify-content: space-evenly;
    transition: all 0.3s ease-in-out;
    cursor: pointer;
}
.links_of_qr_title a.disabled_by_package{
    cursor: not-allowed;
    user-select: none;
    color:gray;
}
.links_of_qr_title li a:hover {
    opacity: 1;
    border-bottom-color: white;
}

.hidden-div {
  display: none;
}

ul.moreQrGenItem {
    display: flex;
    flex-direction: column;
    align-content: stretch;
    align-items: stretch;
    position: absolute;
    background: white;
    box-shadow: 0px 0px 10px 0px gray;
    top: 80%;
    right: -32px;
    border-radius: 2px;
    max-height: 0px;
    overflow: hidden;
    transition: all 0.5s ease-in-out;
    z-index: 1;
}
.moreQrGenItem li a {
    color: var(--primary);
    width: 150px;
    padding: 8px 16px;
    border-bottom: none;
    opacity: 1;
    text-align: left;
    justify-content: flex-start;
}
.moreQrGenItem li a:hover{
    background: var(--primary);
    color: white;
}
li.moreQrGenButton {
    position: relative;
}

li.moreQrGenButton:hover ul.moreQrGenItem,
li.moreQrGenButton:focus ul.moreQrGenItem,
ul.moreQrGenItem:focus
{
    max-height: 600px;
}








.containerHome .container {
  max-width: 400px;
  margin: 0 auto;
  padding: 20px;
}

.containerHome form {
  display: flex;
  flex-direction: column;
}

.containerHome label {
    font-weight: bold;
    margin-top: 10px;
    color: #262626;
    font-size: 16px;
    cursor: pointer;
}

.containerHome textarea{
    resize: vertical;
}

.containerHome button[type="button"]{
    cursor: pointer;
}

.containerHome select {
    /* font-family: fantasy; */
    /* border: 2px solid #FF2F00 !important; */
    letter-spacing: 1px;
    cursor: pointer;
    color: var(--primary);
}

.containerHome input[type="color"]{
    cursor: pointer;
}

.containerHome input,
.containerHome button,
.containerHome select,
.containerHome textarea {
  margin-top: 8px;
  padding: 8px;
  font-size: 14px;
  outline: none;
  border: 1px solid var(--primary);
}

.containerHome #qrCodeContainer {
  margin-top: 20px;
  text-align: center;
}



button#generateButton {
    background: var(--primary);
    color: white;
    border: white;
    border-radius: 3px;
    cursor: pointer;
    padding: 10px;
    font-size: 15px;
}

button#generateButton:hover{
    background: #ff6c00;
}


.qrCodeContainer {
    display: flex;
    flex-direction: column;
    align-items: stretch;
    justify-content: center;
    min-height: 200px;
    min-width: 200px;
    height: 100%;
    width: 100%;
    background: url(/assets/qr_bg.png);
    background-size: contain;
    background-repeat: no-repeat;
}


.downloadableView {
    width: fit-content;
    height: fit-content;
    margin: 0 auto;
}

.wholeQRImageContainer {
    max-width: 250px;
    min-width: 150px;
    width: 100%;
    margin: 32px auto;
    background: white;
    padding: 24px;
    border-radius: 6px;
}


.qrTitleBar {
    padding-top: 24px;
    text-align: center;
    font-size: 20px;
    font-weight: bold;
    text-transform: uppercase;
    outline: none;
    user-select: text;
}



/* //saved qr code */
.qrImagesPage {
    padding: 32px 64px;
    max-width: 1132px;
    margin: 0 auto;
}
.qrImagesPage h2{
    margin: 0;
    color: white;
}
.qrImagesContainer {
    display: flex;
    flex-direction: row;
    flex-wrap: wrap;
    align-content: center;
    align-items: center;
    /* padding: 32px 64px; */
}
.qrImagesContainer .imageItem {
    width: 150px;
    margin: 16px;
    cursor: pointer;
    border: 1px solid transparent;
}
.qrImagesContainer .imageItem .actionBtn {
    display: flex;
    flex-direction: row;
    align-content: center;
    justify-content: space-around;
    align-items: center;
}
.qrImagesContainer .imageItem .actionBtn a{
    text-decoration: none;
}
.qrImagesContainer .imageItem .actionBtn a:hover{
    color: red;
    text-decoration: underline;
}
.qrImagesContainer .imageItem img{
    width: 100%;
    cursor: context-menu;
    pointer-events: visible;
}



/* packagesListTable */

.packageDetails{
    padding: 4px;
    font-size: 14px;
}

.packagesListTable{
    width: max-content;
    padding: 32px;
    border-radius: 0;
    box-shadow: none;
    border: none;
    overflow-x: scroll;
    margin: 16px 0;
    min-width: 100%;
    margin-bottom: 0;
}
.packagesListTable td{
    text-align: center;
}
.packagesListTable .packagesListTitle {
    text-align: right;
    color: #ff2f00;
}
.packagesListTable tr{
    background-color: #efefef;
}
.packagesListTable tr:nth-child(even) {
    background-color: #f7f7f7;
}
.packagesListTable .buyPackage{
    padding: 0px;
    transition: all 0.2s ease-in-out;
}
.packagesListTable .buyPackage:hover{
    scale: 1.1;
    cursor: pointer;
}
.packagesListTable .buyPackage form {
    display: flex;
    align-items: stretch;
    align-content: stretch;
    flex-direction: row;
    justify-content: center;
    flex-wrap: nowrap;
    width: 100%;
    height: 100%;
}
.packagesListTable .buyPackage button {
    padding: 16px;
    background: none;
    color: white;
    outline: none;
    border: none;
    cursor: pointer;
    flex: 1;
}



/* payment form */

form.payment-form {
    width: 500px;
    margin: 100px auto;
    background: white;
    padding: 32px;
    border-radius: 6px;
    box-shadow: 5px 5px 10px -5px gray;
    margin-bottom: -50px;
}
form.payment-form button {
    width: 250px;
    margin: 16px auto;
    padding: 8px;
    border: 1px solid transparent;
    border-radius: 6px;
    background: #ff0f22;
    color: white;
    text-transform: uppercase;
    display: block;
    cursor: pointer;
    font-weight: bold;
}

/* Customize the color of the card input fields */
.StripeElement {
  background-color: #fff;
  padding: 10px;
  border-radius: 4px;
  border: 1px solid #ccc;
}

/* Customize the color of the card input fields on focus */
.StripeElement--focus {
  border-color: #000;
}

/* Customize the color of the error state for the card input fields */
.StripeElement--invalid {
  border-color: #dc3545;
}

.add-amount-input-container {
    display: flex;
    flex-direction: row;
    flex-wrap: nowrap;
    align-content: center;
    align-items: center;
    justify-content: space-between;
    border: 1px solid #cacaca;
    border-radius: 3px;
    margin: 8px 0;
    overflow: hidden;
}
.add-amount-input-container input {
    flex: 1;
    border: 0;
    outline: none;
    padding: 8px 16px;
    cursor: pointer;
}
.add-amount-input-container label {
    padding: 8px;
    user-select: none;
    cursor: pointer;
    color: gray;
}
.methodFlex {
    display: flex;
    flex-direction: row;
    flex-wrap: nowrap;
    align-content: center;
    justify-content: space-between;
    align-items: center;
    color: #ff0f22;
}
.methodFlex button {
    width: max-content !important;
    margin: 4px !important;
    background: white !important;
    color: #ff0f22 !important;
    border: 1px solid #ff0f22 !important;
    font-size: 11px;
    text-transform: capitalize !important;
}




































/* mobile screen */
.nav-menus-mobile{
    display: none;
}
@media screen and (max-width: 992px) {
    ul.links_of_qr_title {
        overflow-x: scroll;
    }
    .moreQrGenMoreBtn {
        display: none;
    }
    ul.moreQrGenItem {
        display: flex;
        flex-direction: row;
        align-items: center;
        position: unset;
        max-height: none;
        background: none;
        box-shadow: none;
        overflow: auto;
    }
    .moreQrGenItem li a {
        color: white;
        width: max-content;
        opacity: 0.7;
        padding: 4px 10px;
        border-bottom: 3px solid transparent;
    }
    .nav-menus {
        display: none;
    }
    .nav-menus-mobile{
        display: block;
    }
    .nav-menus-mobile ul{
        padding: 0;
    }
    .nav-menus-mobile ul li{
        list-style: none;
    }
    .nav-menus-mobile ul li a{
        width: max-content;
    }
    .qrImagesPage {
        padding: 16px;
    }
    table.packagesListTable {
        width: max-content;
    }
    .packageListTableContainer{
        width: 100%;
        overflow-x: scroll;
    }
    form.payment-form {
        margin: 16px auto;
        width: 90%;
        display: block;
    }
    .columnM {
        min-height: auto;
    }
    
}











/* footer styles */
.footer{
    /* margin-top: 100px; */
}
.footer .container{
  padding: 40px;
  color: white;
  background: #1b203a;
  max-width: 100% !important;
  width: 100vw !important;
  margin-top: 0;
  border-radius: 0;
}

.footer h4 {
  font-size: 20px;
  font-weight: bold;
  margin-bottom: 20px;
  color: white;
}

.footer-links {
  list-style: none;
  padding: 0;
  margin: 0;
}

.footer-links li {
  display: inline-block;
  margin-right: 10px;
}

.footer-links li a {
  /* color: #333; */
  text-decoration: none;
}


.footer .bottom-bar .container {
    background-color: #0c0f1e;
    display: flex;
    flex-direction: row;
    flex-wrap: wrap;
    align-content: center;
    justify-content: space-between;
    align-items: center;
}

.footer .bottom-bar .container select {
    color: #fff;
    background-color: #66799e;
    border-color: #66799e;
    cursor: pointer;
    transition: all .2s ease;
    letter-spacing: .025em;
    font-size: 1rem;
    padding: 0.7rem;
    border-radius: 0.125rem;
    white-space: nowrap;
    outline: none;
}
.footer .bottom-bar .container select option{
    background: var(--primary);
    color: white;
}

.footer .bottom-bar p,
.footer .bottom-bar ul {
  font-size: 12px;
  color: #666;
  margin: 0;
}

.bottom-bar ul {
  list-style: none;
  padding: 0;
  margin: 0;
}

.footer .bottom-bar ul li {
  display: inline-block;
  margin-right: 10px;
}

.footer .bottom-bar ul li a {
  color: #666;
  text-decoration: none;
}











/* homepage */
.staticHomepage {
    background: white;
    width: 100%;
    overflow: hidden;
    padding-top: 100px;
}
.contentTitle{
    text-align: center;
}
.horizontalUnsmoothScroller::-webkit-scrollbar{
    height: 0px;
}
.horizontalUnsmoothScrollerContainer {
    max-width: 100%;
    overflow: hidden;
    margin: 0 auto;
    position: relative;
}
.horizontalUnsmoothScrollerContainer::after {
    content: "";
    height: 100%;
    display: block;
    width: 150px;
    right: 0;
    top: 0;
    background: linear-gradient(90deg, rgb(255 255 255 / 0%) 0%, rgb(255 255 255) 100%);
    position: absolute;
    z-index: 1;
}
.horizontalUnsmoothScrollerContainer::before {
    content: "";
    height: 100%;
    display: block;
    width: 150px;
    left: 0;
    background: linear-gradient(90deg, rgb(255 255 255) 0%, rgb(255 255 255 / 0%) 100%);
    position: absolute;
    z-index: 1;
}
.horizontalUnsmoothScroller {
    display: flex;
    flex-direction: row;
    flex-wrap: nowrap;
    align-content: center;
    justify-content: space-between;
    align-items: center;
    width: max-content;
    padding: 32px;
    animation: horizontalUnsmoothScroller 50s linear infinite;
}
.horizontalUnsmoothScrollItem {
    height: 100px;
    padding: 32px 16px;
}
.horizontalUnsmoothScrollItem img{
    height: 100%;
    width: auto;
    object-fit: contain;
}


@keyframes horizontalUnsmoothScroller{
    0%{
        transform: translate(0%, 0px);
    }
    50%{
        transform: translate(calc(-50%), 0px);
    }
    100%{
        transform: translate(0%, 0px);
    }
}


.btnToLink{
    background-color: var(--primary);
    color: white;
}

















table {
    width: calc(100% - 2*16px);
    margin: 16px;
}
.flex-form {
    display: flex;
    flex-direction: row;
    margin: 16px;
    background-color: #ffffff;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    align-content: center;
    justify-content: center;
    align-items: stretch;
}

.form-row {
    display: flex;
    align-items: center;
    flex-direction: column;
    padding: 16px;
}

.form-label {
    width: max-content;
    font-size: 14px;
}

select, input[type="text"] {
    display: block;
    flex: 1;
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 5px;
    width: 100%;
}

button, input[type="button"] {
    display: block;
    flex: 1;
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 5px;
    width: 100%;
    cursor: pointer;
    min-width: 100px;
}

.ame4s7-form {
    background-color: #fff;
    padding: 20px;
    border-radius: 5px;
    box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
    margin: 64px 16px;
}

.ame4s7-label {
    display: block;
    font-size: 14px;
}
.ame4s7-input {
    width: 100%;
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
}
textarea.ame4s7-input{
    resize: vertical;
    min-height: 200px;
}
.ame4s7-select {
    width: 100%;
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
}
.ame4s7-button {
    background-color: #007bff;
    color: #fff;
    border: none;
    padding: 10px 20px;
    border-radius: 4px;
    cursor: pointer;
}
.ame4s7-dual-row {
    display: flex;
    flex-direction: row;
    flex-wrap: wrap;
    align-content: center;
    align-items: stretch;
}
.ame4s7-row {
    margin: 8px;
    flex: 1;
}
td img {
    width: 100px;
    height: 100px;
    object-fit: cover;
    border-radius: 6px;
    overflow: hidden;
}


.modeSwitch{
    cursor: pointer;
    user-select: none;
    position: relative;
}
.modeSwitch::after {
    content: ">";
    position: absolute;
    right: 0;
    top: 0;
    bottom: 0;
    transform: rotateZ(90deg);
    font-weight: lighter;
    font-size: 30px;
    color: #793372;
}
.modeClick{
    max-height: 0;
    overflow: hidden;
    transition: all 0.3s ease-in-out;
}
.modeClick.modeShow{
    max-height: 1000px;
    overflow: hidden;
}









/* user popup */

.popUpUserDetails {
    display: none;
}

.popUpUserDetails.shown {
    display: block;
    position: fixed;
    top: var(--navbarHeight);
    left: 0;
    right: 0;
    bottom: 0;
}
.popUpShadow {
    display: block;
    position: absolute;
    background: rgb(0 0 0 / 80%);
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    cursor: pointer;
    z-index: 5;
}

.popUpUserDetails .ame4s7-form{
    z-index: 6;
    position: relative;
    margin: 0;
}

.popUpUser{
    display: none;
}

.popUpUser.shown {
    overflow-y: scroll;
    display: block;
    min-width: 500px;
    max-width: 800px;
    width: 100%;
    margin: 0 auto;
    margin-top: 32px;
    margin-bottom: 32px;
    height: -webkit-fill-available;
    border-radius: 10px;
}



.user-info-container img {
    width: 250px;
    height: 250px;
    object-fit: cover;
    margin: 16px auto;
    display: block;
    border-radius: 50%;
    overflow: hidden;
    border: 5px solid #793372;
}

.user-info-container .fname {
    font-size: 25px;
    margin: 16px auto;
    display: block;
    text-align: center;
}
.popUpUser input,
.popUpUser select {
    margin: 0;
    padding: 7px;
    border: none;
    background: transparent;
    display: block;
    width: 100%;
    height: 100%;
    color: #0075ff;
    outline: none;
}
.popUpUser button{
    margin: 32px auto;
} 