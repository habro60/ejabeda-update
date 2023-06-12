 <div id="payment-failed-modal" class="modal fade" tabindex="-1" aria-labelledby="payment-failed-modal-label" aria-hidden="true">
     <div class="modal-dialog ">
         <div class="modal-content">
             <div class="modal-header">
                 <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

             </div>
             <div class="modal-body ">

                 <div class="text-center">
                     <i class="fa-regular fa-circle-xmark" style="color: #e74b4b; font-size: 70px; margin-bottom:25px;"></i>
                     <h4>Payment Failed</h4>
                     <p> <?php echo $_SESSION['paymentStatusMessage']; ?></p>
                 </div>

             </div>
         </div>
     </div>
 </div>