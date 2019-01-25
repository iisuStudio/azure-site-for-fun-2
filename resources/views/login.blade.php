@extends('layouts.app')

@section('page-css')
    <link type="text/css" rel="stylesheet" href="https://cdn.firebase.com/libs/firebaseui/2.7.0/firebaseui.css" />

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <style>
        html, body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Raleway', sans-serif;
            font-weight: 100;
            height: 100vh;
            margin: 0;
        }

        .full-height {
            height: 100vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }

        .content {
            text-align: center;
        }

        .title {
            font-size: 84px;
        }

        .links > a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .m-b-md {
            margin-bottom: 30px;
        }
    </style>
@endsection

@section('content')
    <div id="firebaseui-auth-container"></div>
@endsection

@section('page-js')
    <script src="https://www.gstatic.com/firebasejs/4.12.1/firebase.js"></script>
    <script>
        // Initialize Firebase
        var config = {
            apiKey: "AIzaSyDJYbJDfSqCJ-EP_s3_0u_8DWlg-lEIEFU",
            authDomain: "azure-site-for-fun.firebaseapp.com",
            databaseURL: "https://azure-site-for-fun.firebaseio.com",
            projectId: "azure-site-for-fun",
            storageBucket: "azure-site-for-fun.appspot.com",
            messagingSenderId: "539319310946"
        };
        firebase.initializeApp(config);
    </script>
    <script type="text/javascript">
        // FirebaseUI config.
        var uiConfig = {
            signInSuccessUrl: '{{url('')}}',
            signInOptions: [
                // Leave the lines as is for the providers you want to offer your users.
                // firebase.auth.GoogleAuthProvider.PROVIDER_ID,
                firebase.auth.FacebookAuthProvider.PROVIDER_ID,
                // firebase.auth.TwitterAuthProvider.PROVIDER_ID,
                // firebase.auth.GithubAuthProvider.PROVIDER_ID,
                firebase.auth.EmailAuthProvider.PROVIDER_ID,
                // firebase.auth.PhoneAuthProvider.PROVIDER_ID
            ],
            // Terms of service url.
            tosUrl: '{{url('')}}'
        };

        // Initialize the FirebaseUI Widget using Firebase.
        var ui = new firebaseui.auth.AuthUI(firebase.auth());
        // The start method will wait until the DOM is loaded.
        ui.start('#firebaseui-auth-container', uiConfig);
    </script>
@endsection

