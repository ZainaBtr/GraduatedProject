<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Styled Image</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }
     
        .container {
            width: 100%;
            margin: 350px auto;          
        }

        .background-image {
            width: 100%;
            height: 100vh;
            position: absolute;
            background-size: cover;
            top: 0;
            left: 0;
            z-index: -1;
        }
       
        .pass {
            position: absolute;
            width: 200px;
            height: 20px;
            top: 80%;
            left: 2%;
            color :#ffffff;
            margin-bottom: 20px;
            text-decoration-line: none;
            text-decoration-thickness: initial;
            text-decoration-style: initial;
            text-decoration-color: initial;
            font-weight:lighter;
        }

        .log {
            position: absolute;
            width: 300px;
            height: 20px;
            top: 19%;
            left: 2%;
            color :#ffffff;
            margin-bottom: 20px;
            text-decoration-line: none;
            text-decoration-thickness: initial;
            text-decoration-style: initial;
            text-decoration-color: initial;
            font-size: 400%;  
        }
        
        .logg {
            position: absolute;
            width: 320px;
            height: 20px;
            top: 40%;
            left: 2%;
            color :#ffffff;
            font-size:100%; 
            font-weight:lighter;  
        }

        .login-button {
            position: absolute;
            width: 107px;
            height: 107px;
            top: 79%;
            left: 33%;
            font-family: 'Inter';
            font-style: normal;
            font-weight: 600;
            font-size: 24px;
            line-height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: #ffffff;
            background-color: #64a78f;
            border-radius: 50%;
            filter: drop-shadow(0px 0px 25px rgba(0, 0, 0, 0.5));
            border: none;
            font-size: 400%; /* تكبير حجم السهم */
            cursor: pointer;
        }

        .login-button:hover {
            background-color: #3e7e6f;
        }

        /* Underline Style for "Forget Password?" */
        .password-underline {
            display: inline-block;
            border-bottom: 1px solid white;
            margin-top: 5px;
            margin-bottom: 20px; /* تعديل هنا لتناسب التباعد المطلوب */
        }

        .warrber {
            width: 420px;
            left: 5%; /* زيادة المسافة على اليمين */
        }

        .inputbox {
            position: relative;
            width: 100%;
            height: 50px;
            margin: 30px 0;
        }

        .inputbox input {
            width: 80%; /* تقليل عرض الحقل */
            height: 100%;
            background: transparent;
            border: none;
            outline: none;
            font-size: large;
            padding-left: 10px;
            border: 5px solid white;
            border-radius: 15px;
            opacity: 1.0;
        }

       
        input[type="password"], input[type="email"], ::placeholder {
            color: white;
        }
    </style>
</head>
<body>
    <img src="assets/images/ne.png" alt="صورة" class="background-image">
    <div class="warrber">
        <form class="container">
            <div class="inputbox">
            <input type="password" name="email" placeholder="password ">
                
            </div>
            <div class="inputbox">
            <input type="email" name="name" placeholder="email">
            </div>
          
        </form>
    </div>
 
    <button class="login-button"> ➙ </button>
    <p  class="log "> Sign Up </p>
    <p  class="logg "> Enter you account to more futures  </p>
    <div class="arrow-forward"></div>
</body>
</html>
