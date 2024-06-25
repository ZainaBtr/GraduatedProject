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
    background-size: cover;
    top: 0;
    left: 0;
    z-index: -1;
  }

  .write {
    position:relative;
    width: 468px;
    height: 73px;

    left: 110%;
    top: calc(50% - 73px/2 - 296px);
    font-family: 'Inter', sans-serif;
    font-style: normal;
    font-weight: 500;
    font-size: 60px;
    line-height: 73px;
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    color: #FF7B1C;
    top: 2%;

  }
  .btn {
    position:relative;
    width: 540px;
    height: 50px;
    margin-left:92%;
    margin-top: 30%;
    font-family: 'Inter', sans-serif;
    font-weight: 600;
    font-size: 40px;
    line-height: 48px;
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    color: #FFFFFF;
    background:#292D3D;
    border-radius: 24px;
    border: none;
    border-radius: 15px;
    cursor: pointer;
    outline: none;
    box-shadow: 0px 0px 25px rgba(0, 0, 0, 0.5);
  }

  .warrber {
       position: relative;
            width: 420px;
            margin-left: 1.5%; /* زيادة المسافة على اليمين */
        }

        .inputbox {
       
            width: 100%;
            height: 50px;
        
         
            margin-top: 50%;     
            margin-left: 94%;
        }

        .login-button {
            position: absolute;
            width: 107px;
            height: 107px;
            top: 25%;
            left: 25%;
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
            font-size: 400%; /* تكبير حجم السهم */
            cursor: pointer;
            ;
        }

        .inputbox input {
        
             width: 525px; /* تقليل عرض الحقل */
             height: 48px;
             left: 300%;
             top: 70px;
             border: none;
             outline: none;
             font-size: large;
             border-radius: 15px;
             background-color: #FF7B1C;
             color: #FFFFFF;
    
        }
      
       
      input[type="email"], ::placeholder {
     color: #FFFFFF;

    padding-left: 2%; /* إضافة مسافة من اليسار للنص */
}


</style>
</head>
<body>
<div class="container">
  <img src="assets/images/emmm.png"  alt="Image Description" class="img">
  <div class="warrber">
        <form class="container" action="{{ route('forgetPassword') }}" method="POST">
            @csrf
            <div class="inputbox">
                <input type="email" name="email" placeholder="Email">
            </div>
            <button type="submit" class="btn">Next</button>
            <button type="submit" class="login-button">⬅</button>
        </form>
</div>
<p class="write">Enter your Email</p>

 
<script>
  // You can add JavaScript functionality here if needed
</script>
</body>
</html>
