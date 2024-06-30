<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>E</title>
<style>
/* Your existing styles */
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
    position: relative;
    text-align: center;
    padding-top: 100px;
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
    margin-left: 11%;
}

.email-message {
    position: relative;
    font-weight: 300;
    font-size: 19px;
    line-height: 36px;
    max-width: 50%;
    margin-left: 30%;
    top: 40px;
    color: #717F8A;
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
    font-size: 400%;
    cursor: pointer;
}

.resend-link {
    color: #007bff;
    text-decoration: underline;
    cursor: pointer;
}

.input-number,
.input-numbe,
.input-numb,
.input-num,
.input-nu,
.input-n {
    box-sizing: border-box;
    position: absolute;
    width: 86.89px;
    height: 86.89px;
    font-size: 200%;
    top: 100%;
    border: 5px solid #292D3D;
    border-radius: 25px;
    align-items: center;
    text-align: center; /* Align text in the center */
    vertical-align: middle; /* Align text vertically in the middle */
}

.input-number { left: 32%; }
.input-numbe { left: 42%; }
.input-numb { left: 52%; }
.input-num { left: 62%; }
.input-nu { left: 72%; }
.input-n { left: 82%; }

.resend-verification {
    position: absolute;
    width: 428px;
    height: 42px;
    left: 40%;
    top: 180%;
    font-family: 'Inter', sans-serif;
    font-style: normal;
    font-weight: 200;
    font-size: 35px;
    line-height: 42px;
    text-align: center;
    color: #717F8A;
}

.btn {
    position: relative;
    width: 560px;
    height: 50px;
    left: 37%;
    top: 220px;
    font-family: 'Inter', sans-serif;
    font-weight: 600;
    font-size: 40px;
    line-height: 48px;
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    color: #FFFFFF;
    background: #64A78F;
    border-radius: 24px;
    border: none;
    cursor: pointer;
    outline: none;
    box-shadow: 0px 0px 25px rgba(0, 0, 0, 0.5);
}
</style>
</head>
<body>
<div class="container">
    <img src="assets/images/gr.png" alt="Image Description" class="img">
    <div class="verification-code">Verification Code</div>
    <div class="email-message">
        <p>We sent a message to Please check your email and get the verification code. If you don’t receive the message, click "Resend Verification Code".</p>
    </div>
    
    <form action="{{ route('verification') }}" method="POST" id="verificationForm">
        @csrf
        @method('DELETE')
        <input type="text" class="input-number" maxlength="1">
        <input type="text" class="input-numbe" maxlength="1">
        <input type="text" class="input-numb" maxlength="1">
        <input type="text" class="input-num" maxlength="1">
        <input type="text" class="input-nu" maxlength="1">
        <input type="text" class="input-n" maxlength="1">
        <input type="hidden" name="token" id="hiddenToken">
        <button type="submit" class="btn">Next</button>
    </form>
    
    <button class="login-button">⬅</button>
    <div class="resend-verification">Resend Verification Code!</div>
</div>
<script>
document.getElementById('verificationForm').addEventListener('submit', function(event) {
    event.preventDefault();
    let token = '';
    document.querySelectorAll('.input-number, .input-numbe, .input-numb, .input-num, .input-nu, .input-n').forEach(function(input) {
        token += input.value;
    });
    document.getElementById('hiddenToken').value = token;

    // Debugging: log the token to ensure it's correct
    console.log('Token:', token);

    if (token.length === 6) {
        this.submit();
    } else {
        alert('Please enter the 6-digit verification code.');
    }
});
</script>
</body>
</html>
