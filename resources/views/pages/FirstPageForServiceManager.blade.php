<!DOCTYPE html>
<html lang="ar">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>FirstPageForSystemManager</title>
<style>
  body {
    margin: 0;
    padding: 0;
    font-family: Arial, sans-serif;
  }
  .container {
    position: relative;
    text-align: center;
    color: white;
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
  .content {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
  }
  .btnn {
    position: absolute;
    width: 107px;
    height: 48px;
    left: calc(50% - 107px/2 - 594.5px);
    top: calc(50% - 48px/2 + 163.5px + 280px); /* زيادة 100px لنقل الزر للأسفل */
    font-family: 'Inter', sans-serif;
    font-weight: 600;
    font-size: 24px;
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
    text-decoration-line: none;
  }
  .btn {
    position: absolute;
    width: 107px;
    height: 48px;
    left: calc(50% - 107px/2 - 594.5px);
    top: calc(50% - 48px/2 + 163.5px + 200px); /* زيادة 100px لنقل الزر للأسفل */
    font-family: 'Inter', sans-serif;
    font-weight: 600;
    font-size: 24px;
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
    text-decoration-line: none;
  }
</style>
</head>
<body>

<div class="container">
  <img src="assets/images/first.png" alt="صورة" class="background-image">
  <div class="content">
    <!-- زر Sign Up -->
    <a href="{{route('showAllAdvancedUsers')}}" data-category="Sign Up" class="btn">Sign Up</a>
    <!-- زر Login -->
    <a href="/d"Login class="btnn">Login</a>
  </div>
</div>

</body>
</html>
