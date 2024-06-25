<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Email Subscription Form</title>
<style>
    body {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: Arial, sans-serif;
    }

    .container {
        position: absolute;
    }

 .img {
    width: 100%;
    height: 100vh;
    position: absolute;
    background-image: url('assets/images/em.bmp'); /* تعيين الصورة كخلفية */
    background-size: cover;
    top: 0;
    left: 0;
    z-index: -1;
    /* يمكنك إزالة هذا الخط إذا لم تعد بحاجة له */
    /* display: none; */
}

    .write {
        position: relative;
        width: 500px;
        height: 100px;
        left: 650px;
        top: calc(50% - 73px/2 - 296px);
        font-family: 'Inter', sans-serif;
        font-style: normal;
        font-weight: 500;
        font-size: 50px;
        line-height: 73px;
        display: flex;
        color: #FF7B1C;
        top: 2%;
    }

    .login-button {
        position: absolute;
        width: 107px;
        height: 107px;
        top: 15%;
        left: 15%;
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
        background-color: #FF7B1C;
        border-radius: 50%;
        filter: drop-shadow(0px 0px 25px rgba(0, 0, 0, 0.5));
        border: none;
        font-size: 400%;
        cursor: pointer;
    }

    /* Styles for the form and input */
    .form-container {
        position: absolute;
        width: 900px;
        height: 73px;
        left: 620px;
        top: 280px;
    }

    .form-input {
        box-sizing: border-box;
        position: absolute;
        height: 73px;
        left: 0;
        right: 375px;
        top: -100px;
        background: #FF7B1C;
        border: 5px solid #FF7B1C;
        border-radius: 25px;
        display: flex;
        align-items: center;
        padding-left: 20px; /* تحريك النص لليسار */
    }

    .pass {
            position: absolute;
            width: 200px;
            height: 20px;
            top: 70%;
            left:50%;
            color :#717F8A;
            margin-bottom: 20px;
            text-decoration-line: none;
            text-decoration-thickness: initial;
            text-decoration-style: initial;
            text-decoration-color: initial;
            font-weight:lighter;
            font-size: 20px;
        }
        .pas {
            position: absolute;
            width: 400px;
            height: 30px;
            top: 80%;
            left:48%;
            color :#717F8A;
            margin-bottom: 20px;
            text-decoration-line: none;
            text-decoration-thickness: initial;
            text-decoration-style: initial;
            text-decoration-color: initial;
            font-weight:lighter;
            font-size: 21px;
        }
        .pasa {
            position: absolute;
            width: 400px;
            height: 30px;
            top: 90%;
            left:50%;
            color :#717F8A;
            margin-bottom: 20px;
            text-decoration-line: none;
            text-decoration-thickness: initial;
            text-decoration-style: initial;
            text-decoration-color: initial;
            font-weight:lighter;
            font-size: 21px;
        }



    .form-inpu {
        box-sizing: border-box;
        position: absolute;
        height: 73px;
        left: 0;
        right: 375px;
        top: 15px;
        background: #FF7B1C;
        border: 5px solid #FF7B1C;
        border-radius: 25px;
        display: flex;
        align-items: center;
        padding-left: 20px; /* تحريك النص لليسار */
    }
    .form-inp {
        box-sizing: border-box;
        position: absolute;
        height: 73px;
        left: 0;
        right: 375px;
        top: 120px;
        background: #FF7B1C;
        border: 5px solid #FF7B1C;
        border-radius: 25px;
        display: flex;
        align-items: center;
        padding-left: 20px; /* تحريك النص لليسار */
    }

    .full-name {
        position: absolute;
        height: 30px;
        left: 20px; /* تحريك النص لليسار */
        top: calc(50% - 30px/2); /* تحريك النص للأسفل */
        font-family: 'Inter';
        font-style: normal;
        font-weight: 200;
        font-size: 25px;
        line-height: 30px;
        display: flex;
        align-items: center;
        color: #FFFFFF;
       
    }
</style>
</head>
<body>

<img src="\assets\images\b.png" alt="Image Description" class="img">
<p class="write">My Account</p>
<button class="login-button">⬅</button>


<div class="form-container">
    <div class="form-input">
        <span class="full-name">{{ $user->fullName }}</span>
    </div>
    <div class="form-inpu">
        <span class="full-name">{{ $user->email }}</span>
    </div>
    <div class="form-inp">
        <span class="full-name">{{ $user->position }}</span>
    </div>
</div>


<a href="/kk" data-category="Change your email!" class="pass">Change your email !</a>
<a href="/FF" data-category="Change your password !" class="pas">Change your password !</a>
<a href="/pp" data-category="Change your password !" class="pasa">forget password !</a>

</body>
</html>
