<script>

  export default {
    name: 'App'
  }
</script>

<template>
  <div id="app">
    <router-view />
  </div>
</template>

<style>
  @import url('https://fonts.googleapis.com/css2?family=Oxanium:wght@200..800&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap');

  * {
    box-sizing: border-box;
  }

  body {
    background: #2e2e2e !important;
    min-height: 100vh;
    display: flex;
    font-weight: 400;
    font-family: 'Roboto', sans-serif;
    color: #ececec;
  }

  h1, h2, h3, h4, h5, h6, label, span {
    font-weight: 500;
    font-family: 'Roboto', sans-serif;
  }

  body, html, #app, #root, .auth-wrapper {
    width: 100%;
    height: 100%;
  }

  #app {
    text-align: center;
  }

  .navbar-light {
    background-color: #222222;
    color: #fff;
  }

  .navbar-light a {
    color: #ececec;
  }

  .navbar-light a:hover {
    color: #aeaeae;
  }

  .navbar-collapse {
    flex: 0;
  }

  .auth-wrapper {
    display: flex;
    justify-content: center;
    flex-direction: column;
    text-align: left;
  }

  .auth-inner {
    width: 60%;
    margin: auto;
    background-color: #222222;
    padding: 40px 55px 45px 55px;
    border-radius: 15px;
    transition: all .3s;
  }

  .auth-wrapper .form-control:focus {
    border: #167bff 3px solid;
    box-shadow: none;
  }

  .auth-wrapper h3 {
    text-align: center;
    margin: 0;
    line-height: 1;
    padding-bottom: 20px;
  }

  .custom-control-label {
    font-weight: 400;
  }

  .forgot-password,
  .forget-password a {
    text-align: right;
    font-size: 13px;
    padding-top: 10px;
    color: #ececec;
    margin: 0;
  }

  .forgot-password a {
    color: #167bff;
  }

  .btn-block {
    width: 100%;
    background-color: #167bff !important;
  }

  .error {
    white-space: pre;
  }
</style>
