<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>@yield('title')</title>
  <link rel="shortcun icon" href="{{ asset('assets/img/favicon.png') }}" type="image/x-icon" />
  <style type="text/css">
    .clearfix:after {
      content: "";
      display: block;
      clear: both;
    }

    .page-break {
      page-break-after: always;
    }

    a {
      color: #5D6975;
      text-decoration: underline;
    }

    body {
      width: 90%;position: relative;
      margin: 0 auto; 
      color: #001028;
      background: #FFFFFF; 
      padding: 20px;
      font-family: Courier New,Courier,Lucida Sans Typewriter,Lucida Typewriter,monospace;
      font-size: 12px;
      font-style: normal;
      font-variant: normal;
      font-weight: 500;
      letter-spacing: 2px;
    }

    @media  print {
      html, body {
        width: 11.5in;
        height: 5.5in;
        display: block;
        margin": 0 auto;
        font-family: "Calibri";
      }

      @page  {
        size: 5.5in 8.5in;
      }
    }

    h1 {
      border-top: 1px solid #5D6975;
      border-bottom: 1px solid #5D6975;
      color: #5D6975;
      font-size: 2.4em;
      line-height: 1.4em;
      font-weight: normal;
      text-align: center;
      margin: 0 0 20px 0;
    }

    #project span {
      color: #5D6975;
      text-align: right;
      width: 100px;
      margin-right: 10px;
      display: inline-block;
      font-size: 0.8em;
    }

    #company {
      float: right;
      text-align: right;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      border-spacing: 0;
      margin-bottom: 20px;
    }

    table th {
      padding: 5px;
      color: #5D6975;
      border: 1px solid #C1CED9;
      white-space: nowrap;        
      font-weight: normal;
      text-align: left;
      font-weight: 700;
    }

    table tr.blue {
      background-color: #454f96;
      color: #fff;
      font-weight: 700;
    }

    table tr.blue th {
      background-color: #454f96;
      color: #fff;
      font-weight: 700;
    }

    table tr.blue a {
      color: #fff;
      font-weight: 700;
    }

    table tr.green {
      background-color: #2f713a;
      color: #fff;
      font-weight: 700;
    }

    table tr.green th {
      background-color: #2f713a;
      color: #fff;
      font-weight: 700;
    }

    table tr.green a {
      color: #fff;
      font-weight: 700;
    }

    table tr.red {
      background-color: red;
      color: #fff;
      font-weight: 700;
    }

    table tr.red th {
      background-color: red;
      color: #fff;
      font-weight: 700;
    }

    table tr.red a {
      color: #fff;
      font-weight: 700;
    }

    table th[align="center"] {
      text-align: center;
    }

    table .main {
      vertical-align: top;
    }

    table.info thead td,
    table.info tfoot td {
      padding: 5px;
      text-align: left;
    }

    table.info tbody td {
      padding: 80px;
    }

    table td {
      padding: 5px;
      border: 1px solid #C1CED9;
    }

    table td.unit,
    table td.qty,
    table td.total {
      font-size: 1.2em;
    }

    table td.grand {
      border-top: 1px solid #C1CED9;
      border-bottom: 1px solid #C1CED9;
      font-weight: 700;
    }

    #notices .notice {
      color: #5D6975;
      font-size: 1.2em;
    }

    footer {
      color: #5D6975;
      width: 100%;
      height: 30px;
      border-top: 1px solid #C1CED9;
      padding: 8px 0;
      margin-top: 50px;
      text-align: center;
    }
  </style>
</head>
<body>
  @yield('content')
</body>