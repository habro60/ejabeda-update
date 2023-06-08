         <!DOCTYPE html>
         <html>

         <head>
             <title>Auto fill Address</title>
             <script type="text/javascript">
                 function auto_fill_address() {
                     var same_addr = document.getElementById("same_residential_permanent").checked;
                     var resaddr = document.getElementById("residential_address").value;
                     var respin = document.getElementById("residential_pin").value;
                     //alert(x);
                     if (same_addr) {
                         if ((resaddr == '' || resaddr == null) || (respin == '' || respin == null)) {
                             alert('please fill address and pincode');
                             document.getElementById("same_residential_permanent").checked = false;
                         } else {
                             document.getElementById("permanent_address").value = resaddr;
                             document.getElementById("permanent_pincode").value = respin;
                         }
                     } else {
                         document.getElementById("permanent_address").value = '';
                         document.getElementById("permanent_pincode").value = '';
                     }
                 }
             </script>
         </head>

         <body>
             <form action="#" method="post" enctype="">
                 <p>
                     <label for="residential_address">Current Address</label>
                     <textarea placeholder="Enter address" name="residential_address" id="residential_address"></textarea>
                 </p>
                 <p>
                     <label for="residential_pin">Current Pin code</label>
                     <input type="text" placeholder="Enter Pincode" name="residential_pin" id="residential_pin" />
                 </p>
                 <p>
                     <label for="same_residential_permanent">If Residencial address is as address</label>
                     <input type="checkbox" name="same_residential_permanent" id="same_residential_permanent" value="abcde" onclick="return auto_fill_address();" />
                 </p>
                 <p>
                     <label for="permanent_address">Parmanent Address</label>
                     <textarea placeholder="Enter  address" name="permanent_address" id="permanent_address"></textarea>
                 </p>
                 <p>
                     <label for="permanent_pincode">Parmanent Pincode</label>
                     <input type="text" placeholder="Enter pincode" name="permanent_pincode" id="permanent_pincode" />
                 </p>
             </form>

         </body>

         </html>