@extends('layouts.master')


@section('page-header')

    <!-- breadcrumb -->
@section('PageTitle')
    Meal
@stop
<!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->

   <style>
  /* Reset styles */
 

  /* Styled Table */
  .styled-table {
    width: 80%; /* زيادة عرض الجدول */
    text-align: center;
    border: 1px solid #ddd;
    
    margin-top: 10%;
    margin-left: 10%; 
    vertical-align: middle;/* تحديد هامش لليسار لتوسيع المساحة العرضية */
}


.styled-table th,
.styled-table td {
    border: none; /* حذف الحدود العمودية للخلايا */
    padding: 10px;
    text-align: center;
    width: auto; /* إعادة تعيين عرض الخلية إلى تحديد التلقائي */
}

.styled-table tr th {
    border-right-color: transparent; /* حذف الحدود العمودية للعناصر الفردية */
}


.styled-table th {
    background-color: #292D3D;
    color: #FFFFFF;
    text-align: center; /* زيح الكلمات إلى اليسار في عمود "Service Year" */
    padding-left: 20px;
    vertical-align: middle;  /* تحديد هامش لليسار داخل الخلية */
}

  /* تغيير لون خطوط الجدول العمودية */
.styled-table tr th,
.styled-table tr td {
  border-right-color: white;
  text-align: center;
}
.child-column {
            color: transparent;
            text-align: center;
            margin-left: 10px;
        }
        .vertical-align-top {
            vertical-align: top;
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
    left: 800px;
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
 
  .styled-account:hover {
    background-color: #39465E; /* Changed hover background color */
  }

  /* تغيير لون النص في أعمدة الأبناء إلى شفاف */
  .child-column {
    color: transparent;
  }
  .btn-succes {
  background-color: #FF7B1C; 
  color:white;/* لون الزر البرتقالي */
}

.btn-succes:hover {
  background-color: #FF7B1C; /* لون الزر البرتقالي عند التحويم */
}

.btn-succes:active {
  background-color: orange; /* لون الزر البرتقالي عند الضغط */
}

</style>
<table class="styled-table">
    <tr>
      <th >service</th>
    
      <th>Processes<th>
    </tr>
    <tr>
  
      <td>enginerring barmaj</td>
      <td><button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                                data-target="#Delete"
                                                title=Delete><i
                                                class="fa fa-trash"></i></button></td>
    </tr>
  
    <!-- تكرار الصفوف الأخرى هنا حسب الحاجة -->
  </table>

  <!-- Group 20 -->
 
    <!-- Add Service Manager -->
   
  
    
    <button class="styled-button" data-toggle="modal" data-target="#exampleModal">Add ROLES</button>



                                <!-- delete_modal_Grade -->

                                <div class="modal fade" id="Delete" tabindex="-1" role="dialog"
                                     aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title"
                                                    id="exampleModalLabel">
                                                   delete
                                                </h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                             
                                                    <input  type="hidden" name="id" class="form-control"
                                                           value="">
                                                     <input type="text" readonly value="" class="form-control">
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal"> No </button>
                                                        <button type="submit"
                                                                class="btn btn-danger"> yes</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                 

                        </table>
                    </div>
                </div>
            </div>
        </div>


       
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add service</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- أضف العناصر التي تريد عرضها في هذه النافذة -->
        <div class="row">
          <div class="col">
            <label for="Name" class="mr-sm-2">role:</label>
            <input id="category_name" type="text" name="category_name" class="form-control">
          </div>

        </div>
        
      
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">consol</button>
        <button type="button" class="btn btn-succes">save</button>
      </div>
    </div>
  </div>
</div>
    <!-- row closed -->
@endsection
@section('js')
    @toastr_js
    @toastr_render
@endsection
