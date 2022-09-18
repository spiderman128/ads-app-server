<?php
require_once( __DIR__ . '/../../dev-control.php' );

if(!empty($_SESSION['cp']) && !empty($_SESSION['cge'])) {
    $bg_primary = 'linear-gradient( #' . $_SESSION['cp'] . ', #' . $_SESSION['cge'] . ' );';
} else {
   $bg_primary = 'linear-gradient( ' . _COLOR_PRIMARY_ . ', ' . _COLOR_GRADIENT_END_ . ' );';
   $bg_top = 'linear-gradient( ' . _COLOR_PRIMARY_ . ', ' . _COLOR_PRIMARY_ . ' );';
}
?>
*{ margin:0 ;padding=0;}
.bg-primary { background: #f0f8ff !important; }
.bg-main { background: <?= $bg_top ?> !important; }
.profile { 
      background: <?= $bg_top ?> !important;
      border-bottom-left-radius: 80px 80px;
      padding: 10px;
      
}
.userinfo{
    float: left;
    padding: 15px;
    text-align: left;
    width: 50%;
    margin: 0;
}
.userinfo h4{
    line-height: normal !important;
    padding: 0;
    margin: 0;
    }
.icon { 
    float: left;
    width: 40%;
    margin-right: 10px; 
}    
.user-block {
    display: inline-block ;
    width: 100%;
}
.line1{
    display: inline-block ;
    width: 100%;
    margin:0 auto;
    display: flex;
    justify-content: center;
    align-items: center;
}
.item {
    float: left;
    width: 26%;
    margin:0 auto;
    margin: 8px;
    color: black;
    background: white;
    border: 1px solid #e8e8e8;
    border-radius: 8px ;
    padding: 10px;
    display: inline-block ;
}
.items {
    margin:20px;
    
   color: black;
    background: white;
    border: 1px solid #e8e8e8;
    border-radius: 8px ;
    padding: 10px;
}
i, .material-icons {
  font-family: 'Material Icons';
  font-weight: normal;
  font-style: normal;
  font-size: 24px;
  line-height: 1;
  letter-spacing: normal;
  text-transform: none;
  display: inline-block;
  white-space: nowrap;
  word-wrap: normal;
  direction: ltr;
  -webkit-font-smoothing: antialiased;
  
}
.icons:active {
	transform: scale(0.8);
}
.icons {
    margin:10px;
    color: white;
    font-size: 28px;
    background: <?= $bg_top ?> !important;
    border-radius: 50% ;
    padding: 10px;
    transition: all 0.1s ease-in-out;
}

.block-main{
   width: 100%;
   margin:0 auto;
   margin-bottom: 100px;
}
.block-header{
   margin-top: 10px;
   padding: 10px;
}
.footer {
   position: fixed;
   left: 0;
   margin-top: 120px;
   bottom: 0;
   width: 100%;
   background: <?= $bg_top ?> !important;
   color: white;
   padding: 20px;
   text-align: center;
   border-radius: 25px 25px 0px 0px;
}
.notice-block {
    float: left;
    width: 80%;
    margin:0 auto;
    margin: 8px;
    color: black;
    background: white;
    border: 1px solid #e8e8e8;
    border-radius: 15px ;
    padding: 6px;
    display: inline-block ;
    -ms-transform: translateY(-100px);
    transform: translateY(-100px);
}
.topbar { 
      background: <?= $bg_top ?> !important;
      border-radius:0px 0px 60px 60px;
      padding: 10px;
      
}
.notice-bg {
    display: flex;
    justify-content: center;
    align-items: center;
}
.modal{
    margin:0 auto;
    Width: 80%;
    padding: 0!important;
    
}
.modal:before {
  content: '';
  display: inline-block;
  height: 100%;
  vertical-align: middle;
  margin-right: -4px; /* Adjusts for spacing */
}
@import url(https://fonts.googleapis.com/css?family=Roboto:400,300,500,700,100);

/* ----- DIALOG/MODAL ----- */
/* FADE/SCALE EFFECT */
	.modal-dialog {
  display: inline-block;
  text-align: left;
  vertical-align: middle;
}

/* DIALOG CONTENT */
	.modal-content {
		border: none;
		border-radius: 2px;
		border-shadow: none;
		margin-top: 0;
    margin-bottom: 0;
    height: 100%;
	}

/* DIALOG HEADER */
	.modal-header {
		min-height: 16px;
		padding: 24px;
		border-bottom: none;
	}

	.modal-title {
		font-weight: 500;
		font-size: 21px;
	}

	/* DIALOG BODY */
	.modal-body {
		padding: 18px;
	}

	.modal-body p {
		font-weight: 400;
		font-size: 14px;
		color: #212121;
	}

	.modal-body .lead {
		font-weight: 300;
		font-size: 14px;
		color: black;
		font-family: 'Hind Siliguri', sans-serif;
		text-align: left;
	}

	.modal-body p:last-child,
	.modal-body .lead:last-child {
		margin-bottom: 0;
	}

/* DIALOG FOOTER */
	.modal-footer {
		padding: 10px;
		border-top: 1px solid #ccc;
		padding:0;
	}

	.modal-footer .btn {
		height: 36px;
		margin-right: 8px;
		margin-top: 0px;
		margin-botom: 0px;
		border: none;
		border-radius: 0;
		text-transform: uppercase;
		font-weight: 500;
		color: #009688;
		background-color: #fff;
	}

	.modal-footer .btn:focus {
		outline: none;
		box-shadow: none;
	}

	.modal-footer .btn:focus,
	.modal-footer .btn:hover {
		color: #00796B;
	}

	.modal-footer .btn + .btn {
		margin-left: 0;
	}

	.modal-footer .btn + .btn:last-child {
		margin-left: -4px;
	}


/* ----- v CAN BE DELETED v ----- */
body {
	font-family: 'Roboto', sans-serif;
	background-color: #EF5350;
}

.demo {
	padding-top: 60px;
	padding-bottom: 110px;
}

.btn-demo {
	margin: 15px;
	padding: 10px 15px;
	border-radius: 0;
	font-size: 16px;
	background-color: #FFFFFF;
}

.btn-demo:focus {
	outline: none;
}

.demo-footer {
	position: fixed;
	bottom: 0;
	width: 100%;
	padding: 15px;
	background-color: #212121;
	text-align: center;
}

.demo-footer > a {
	text-decoration: none;
	font-weight: bold;
	font-size: 16px;
	color: #fff;
}

//swal

.swal2-title {
    font-size: 1.875em !important; 
}

