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
        position: relative;
        width: 500px;
        height: 100px;
        left: 520px;
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
    .btn {
        width: 102%;
        height: 50px;
        font-family: 'Inter', sans-serif;
        font-weight: 600;
        font-size: 24px;
        color: #FFFFFF;
        background: #292D3D;
        border-radius: 24px;
        border: none;
        cursor: pointer;
        outline: none;
        box-shadow: 0px 0px 25px rgba(0, 0, 0, 0.5);
        margin-top: 50px;
        margin-left: 100%;
    }
    .input-group {
        margin-bottom: 10px;
        margin-top: 10%;
    }
    input[type="email"], input[type="password"] {
        width: 100%;
        height: 48px;
        border: none;
        outline: none;
        font-size: large;
        border-radius: 15px;
        background-color: #FF7B1C;
        color: #FFFFFF;
        padding-left: 2%; /* إضافة مسافة من اليسار للنص */
        margin-left: 100%; /* التحكم في المسافة من اليسار */
    }
    ::placeholder {
        color: #FFFFFF;
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
        text-decoration-line: none;
        text-decoration-thickness: initial;
        text-decoration-style: initial;
        text-decoration-color: initial;
    }
</style>
</head>
<body>
<div class="container">
    <img src="assets/images/emmm.png" alt="Image Description" class="img">
    <p class="write">Enter your information</p>
    <div class="input-group">
        <form action="{{ route('updateEmail') }}" method="POST">
            @csrf
            <input type="password" name="password" placeholder="Password">
            <div class="input-group">
                <input type="email" name="email" placeholder="New Email">
            </div>
            <button type="submit" class="btn">Next</button>
        </form>
    </div>
    <button class="login-button">⬅</button>
</div>

<script>
  // يمكنك إضافة وظائف JavaScript هنا إذا لزم الأمر
</script>
</body>
</html>
