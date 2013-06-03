<div class="authorize_net" id="authorizenetoptions" style="display:none">
<div class="addlisting_row">
<label>Card Holder Name : </label> <input type="text" value="" id="cardholder_name" name="cardholder_name" class="textfield"/>
</div>

<div class="addlisting_row">
<label>Card Type : </label> <select class="select_s" id="cc_type" name="cc_type" >
          <option value="">-- select card type --</option>
          <option value="VISA">Visa</option>
          <option value="DELTA">Visa Delta</option>
          <option value="UKE">Visa Electron</option>
          <option value="MC">Master Card</option>
        </select>
</div>

<div class="addlisting_row">
<label>Credit/Debit Card number  :  </label> <input type="text" autocomplete="off" size="25" maxlength="25" id="cc_number" name="cc_number" class="textfield"/>
</div>

<div class="addlisting_row">
<label>Expiry Date :   </label> <select  class="select_s2" id="cc_month" name="cc_month">
          <option selected="selected" value="">month</option>
          <option value="01">01</option>
          <option value="02">02</option>
          <option value="03">03</option>
          <option value="04">04</option>
          <option value="05">05</option>
          <option value="06">06</option>
          <option value="07">07</option>
          <option value="08">08</option>
          <option value="09">09</option>
          <option value="10">10</option>
          <option value="11">11</option>
          <option value="12">12</option>
        </select>
        <select class="select_s2" id="cc_year" name="cc_year">
          <option selected="selected" value="">year</option>
          <?php for($y=date('Y');$y<date('Y')+5;$y++){?>
          <option value="<?php echo $y;?>"><?php echo $y;?></option>
          <?php }?>
        </select>
</div>

<div class="addlisting_row">
<label>CV2 (3 digit security code) : </label> <input type="text" autocomplete="off" size="4" maxlength="5" id="cv2" name="cv2" class="textfield2"/>
</div>


</div> <!--authorize_net #end   -->