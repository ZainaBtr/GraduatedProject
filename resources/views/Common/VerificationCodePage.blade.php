<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>E</title>
<style>
body {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Inter', sans-serif;
}
.img {
    width: 100%;
    height: 100vh;
    position: absolute;
    background-size: cover;
    top: 0;
    left: 0;
    z-index: -1;
}

.container {
    position: relative; /* Changed to relative */
    text-align: center; /* Center the content */
    padding-top: 100px; /* Added padding to center content vertically */
}

.verification-code,
.email-message {
    font-family: 'Inter', sans-serif;
    color: #292D3D;
}

.verification-code {
    font-weight: 700;
    font-size: 60px;
    line-height: 73px;

    margin-top: 10px;
    margin-left: 11%; /* Added margin for spacing */
}

.email-message {
    position: relative;
    font-weight: 200;
    font-size: 20px;
    line-height: 36px;
    max-width: 50%;
    margin-left:30%;
    top: 40px;
    color:#717F8A;
   
    
}

.login-button {
            position: absolute;
            width: 107px;
            height: 107px;
            top: 15%;
            left: 11%;
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
            background-color: #64A78F;
            border-radius: 50%;
            filter: drop-shadow(0px 0px 25px rgba(0, 0, 0, 0.5));
            border: none;
            font-size: 400%; /* تكبير حجم السهم */
            cursor: pointer;
            ;
        }
.resend-link {
    color: #007bff;
    text-decoration: underline;
    cursor: pointer;
}
/* يمكنك تعيين العناصر التالية بناءً على تفضيلات التصميم الخاصة بك */

/* إضافة بوردر للإدخال الأرقام بنفس الحجم والأسلوب */
.input-number {
    box-sizing: border-box;
    position: absolute;
    width: 86.89px;
    height: 86.89px;
    font-size: 200%;
    left: 32%;
    top: 125%;
    border: 5px solid #292D3D;
    border-radius: 25px;
    align-items: center;
}

.input-numbe {
    box-sizing: border-box;
    position: absolute;
    width: 86.89px;
    height: 86.89px;
    font-size: 200%;
    left: 42%;
    top: 125%;
    border: 5px solid #292D3D;
    border-radius: 25px;
    align-items: center;
}

.input-numb {
    box-sizing: border-box;
    position: absolute;
    width: 86.89px;
    height: 86.89px;
    font-size: 200%;
    left: 52%;
    top: 125%;
    border: 5px solid #292D3D;
    border-radius: 25px;
    align-items: center;
}

.input-num {
    box-sizing: border-box;
    position: absolute;
    width: 86.89px;
    height: 86.89px;
    font-size: 200%;
    left: 62%;
    top: 125%;
    border: 5px solid #292D3D;
    border-radius: 25px;
    align-items: center;
    
}
.input-nu {
    box-sizing: border-box;
    position: absolute;
    width: 86.89px;
    height: 86.89px;
    font-size: 200%;
    left: 72%;
    top: 125%;
    border: 5px solid #292D3D;
    border-radius: 25px;
    align-items: center;
    
}

.resend-verification {
    position: absolute;
    width: 428px;
    height: 42px;
    left: 40%;
    top: 170%;
    font-family: 'Inter', sans-serif;
    font-style: normal;
    font-weight: 200;
    font-size: 35px;
    line-height: 42px;
    text-align: center;
    color:#717F8A;
}
.btn {
    position:relative;
    width: 560px;
    height: 50px;
    left: 37%;
    top:270px;
    font-family: 'Inter', sans-serif;
    font-weight: 600;
    font-size: 40px;
    line-height: 48px;
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    color: #FFFFFF;
    background:#64A78F;
    border-radius: 24px;
    border: none;
    border-radius: 15px;
    cursor: pointer;
    outline: none;
    box-shadow: 0px 0px 25px rgba(0, 0, 0, 0.5);
  }




</style>
</head>
<body>
<div class="container">
    <img src="assets/images/gr.png" alt="Image Description" class="img"> <!-- Placeholder image link -->
    <div class="verification-code">
        Verification Code
    </div>
    <div class="email-message">
       <p> We sent a message to <strong>salam.kwm@gmail.com</strong> please go to email and get the verification code . if you don’t have any message click resend verification code ! </p>
      
    </div>
    <input type="number" class="input-number">
    <input type="number" class="input-numbe">
    <input type="number" class="input-numb">
    <input type="number" class="input-num">
    <input type="number" class="input-nu">
    <div class="resend-verification">Resend Verification Code !</div>
</div>
<button class="btn">Next</button>

<button class="login-button"> ⬅ </button>
</body>
</html>
