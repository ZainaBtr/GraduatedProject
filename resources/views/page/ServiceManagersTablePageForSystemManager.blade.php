<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<title>Styled Table</title>
<style>
  /* Reset styles */
  body, html {
    margin: 0;
    padding: 0;
  }

  /* Styled Table */
  .styled-table {
    width: 70%;
    border-collapse: collapse;
    border: 1px solid #ddd;
    margin-top: 10%;
    margin-left: 13%;
  }

  .styled-table th, .styled-table td {
    border:1px solid  #FF7B1C;
    padding: 8px;
    text-align: center;
    width: 10%;
  }

  .styled-table th {
    background-color: #292D3D;
    color: #FFFFFF;
  }
  /* تغيير لون خطوط الجدول العمودية */
.styled-table tr th,
.styled-table tr td {
  border-right-color: white;
}


  /* تغيير لون خطوط الجدول الأفقية */
 


  /* New styles for Group 20 */
  /* Group 20 */
  .group-20 {
    position: absolute;
    width: 369px;
    height: 81px;
    left: 1254px;
    top: 0px;
  }

  /* Rectangle 21 */
  .rectangle-21 {
    position: absolute;
    width: 369px;
    height: 81px;
    left: 14px;
    top: 20px;
    background: #FF7B1C;
    box-shadow: 0px 0px 50px rgba(0, 0, 0, 0.5);
    border-radius: 0px 0px 30px 30px;
  }

  /* Add Service Manager */
  .add-service-manager {
    position: absolute;
    width: 309.35px;
    height: 34.71px;
    left:20px;
    top: 20px;
    font-family: 'Inter';
    font-style: normal;
    font-weight: 800;
    font-size: 25px;
    line-height: 30px;
    display: flex;
    align-items: center;
    text-align: center;
    text-transform: uppercase;
    color: #FFFFFF;
    box-shadow: 0px 0px 20px rgba(255, 255, 255, 0.5);
  }
  
  /* Button style */
  .styled-button {
    position: absolute;
    width:400px;
    height: 60px;
    left: 1000px;
    top: 0px;
    font-family: 'Inter';
    font-style: normal;
    font-weight: 800;
    font-size: 25px;
    line-height: 30px;
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    text-transform: uppercase;
    color: #FFFFFF;
    background-color: #FF7B1C;
    box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.5);
    border-radius: 0px 0px 30px 30px;
    border: none;
    cursor: pointer;
  }

  .styled-button:hover {
    background-color: #FF983D;
  }

  /* تغيير لون الخطوط العمودية للعناصر الفردية */
  .styled-table tr th {
    border-right-color: transparent;
  }

  /* New styles for Account button */
  .styled-account {
    position: absolute;
    width: 300px;
    height: 60px;
    left: 750px;
    top: 0px;
    font-family: 'Inter';
    font-style: normal;
    font-weight: 800;
    font-size: 25px;
    line-height: 100px;
    display: flex;
    align-items: center;
    justify-content: center;
    text-align:center;
    text-transform: uppercase;
    color: #FFFFFF;
    background-color: #292D3D; /* Changed background color */
    box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.5);
    border-radius: 0px 0px 30px 30px;
    border: none;
    cursor: pointer;
  }

  .styled-account:hover {
    background-color: #39465E; /* Changed hover background color */
  }

  /* تغيير لون النص في أعمدة الأبناء إلى شفاف */
  .child-column {
    color: transparent;
  }
  .btn-succes {
  background-color: #FF7B1C; /* لون الزر البرتقالي */
}

.btn-succes:hover {
  background-color: #FF7B1C; /* لون الزر البرتقالي عند التحويم */
}

.btn-succes:active {
  background-color: orange; /* لون الزر البرتقالي عند الضغط */
}



</style>
</head>
<body>
  <table class="styled-table">
    <tr>
      <th>Full Name</th>
      <th>Position</th>
      <th>Password</th>
      <th>option</th>
    </tr>
    <tr>
      <td>Ammar Joukhadar</td>
      <td>Provost</td>
      <td>1598756</td>
      <td>1598756</td>
    </tr>
    <tr>
      <td>Ammar Joukhadar</td>
      <td>Provost</td>
      <td>1598756</td>
      <td>1598756</td>
    </tr>
    <!-- تكرار الصفوف الأخرى هنا حسب الحاجة -->
  </table>

  <!-- Group 20 -->
 
    <!-- Add Service Manager -->
   
  
    <button class="styled-account" data-toggle="modal" data-target="#exampleModal">My Profile</button>
    <button class="styled-button" data-toggle="modal" data-target="#exampleModal">Add Service Manager</button>

    
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Service Manager</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- أضف العناصر التي تريد عرضها في هذه النافذة -->
        <div class="row">
          <div class="col">
            <label for="Name" class="mr-sm-2"> Full Name:</label>
            <input id="category_name" type="text" name="category_name" class="form-control">
          </div>

        </div>
        <div class="row">
          <div class="col">
            <label for="Name" class="mr-sm-2"> option:</label>
            <input id="category_name" type="text" name="category_name" class="form-control">
          </div>
        </div>
        <div class="row">
          <div class="col">
            <label for="Name" class="mr-sm-2"> password:</label>
            <input id="category_name" type="text" name="category_name" class="form-control">
          </div>
        </div>
      </div>
      
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">consol</button>
        <button type="button" class="btn btn-succes">save</button>
      </div>
    </div>
  </div>
</div>

</body>
</html>
