<div id="content">
        
<form class="form-horizontal" action="<?php echo site_url('staff_dashboard_controller/profileedit')?>" method="post" autocomplete="off">
 <input type="hidden" name="__CSRFToken__" value="12a76e270f30bcbaca3c5faf50b1b350ebd9ff8c"> <input type="hidden" name="do" value="update">
 <input type="hidden" name="id" value="3">
<h2>My Account Profile</h2>
<div class="tab">
  <ul class="clean tabs">
    <li class="active"><a href="#account"><i class="icon-user"></i> Account</a></li>
    <li><a href="#preferences">Preferences</a></li>
    <li><a href="#signature">Signature</a></li>
  </ul>
</div>

  <div class="tab_content" id="account">

    <div class="col-lg-2" style="overflow:auto;">
      <div class="avatar pull-left" style="margin: 10px 15px; width: 100px; height: 100px;">
          <img class="avatar" alt="Avatar" src="//www.gravatar.com/avatar/591979a746b57c8ed09bca89133daeff?s=80&amp;d=identicon">        </div>
    </div>

    <div class="col-lg-10">

      <?php foreach ($result->result() as $value) { ?>

      <div class="form-group" style="overflow:auto;margin-bottom:5px;">
        <label class="col-lg-3 control-label required">Name</label>
        <div class="col-lg-5">
          <input type="text" size="20" class="form-control" maxlength="64" name="firstname" autofocus="" value="<?php echo $value->firstname;?>" placeholder="First Name">
          <div class="error"></div>
        </div>
        <div class="col-lg-4">
          <input type="text" size="20" class="form-control" maxlength="64" name="lastname" value="<?php echo $value->lastname;?>" placeholder="Last Name">
                <div class="error"></div>
        </div>
      </div>

      <div class="form-group" style="overflow:auto;margin-bottom:5px;">
        <label class="col-lg-3 control-label required">Email Address</label>
        <div class="col-lg-9">
          <input type="email" size="40" class="form-control" maxlength="64" name="email" value="<?php echo $value->email;?>" placeholder="e.g. me@mycompany.com">
            <div class="error"></div>
        </div>
      </div>

      <div class="form-group" style="overflow:auto;margin-bottom:5px;">
        <label class="col-lg-3 control-label">Phone Number</label>
        <div class="col-lg-4">
          <input type="tel" class="form-control" size="18" name="phone" value="<?php echo $value->phone;?>">
          <div class="error"></div>
        </div>
        <div class="col-lg-1">
          Ext        </div>
        <div class="col-lg-4">
            <input type="text" size="5" class="form-control" name="phone_ext" value="<?php echo $value->phone_ext;?>">
              <div class="error"></div>
        </div>
      </div>

      <div class="form-group" style="overflow:auto;margin-bottom:5px;">
        <label class="col-lg-3 control-label">Mobile Number</label>
        <div class="col-lg-9">
          <input type="tel" size="18" name="mobile" class="auto phone form-control" value="<?php echo $value->mobile;?>">
            <div class="error"></div>
        </div>
      </div>
  
    </div>

    <div class="col-lg-12" style="font-weight:400;font-size:1.3em;text-align:left;min-height:24px;border-top:1px solid #ddd;border-bottom:1px solid #ddd;padding:5px;margin-bottom:10px;">
      Authentication    </div>
        <div class="form-group">
      <label class="col-lg-3 control-label"><i class="offset help-tip icon-question-sign" href="#username"></i> Username </label>
      <div class="col-lg-9">
        <input type="text" size="40" class="staff-username typeahead form-control" name="username" disabled="" value="<?php echo $value->username;?>">

      <?php } ?>

                  <button type="button" id="change-pw-button" class="action-button" data-toggle="modal" data-target="#cpass-modal">
                  <i class="icon-refresh"></i> Change Password  </button>


                        <div class="error"></div>
      </div>
    </div>
    <div class="col-lg-12" style="font-weight:400;font-size:1.3em;text-align:left;min-height:24px;border-top:1px solid #ddd;border-bottom:1px solid #ddd;padding:5px;margin-bottom:10px;margin-top:10px;">
      Status and Settings    </div>
    <div class="col-lg-12" style="padding-left:30px;">
        <?php foreach ($result->result() as $value) { ?>
            <input value="1" type="checkbox" style="margin-top:10px;" name="show_assigned_tickets" <?php echo ($value->show_assigned_tickets == 1)?"checked":""; ?>>
              <b>Show assigned tickets on open queue.</b>            
              <i class="help-tip icon-question-sign" href="#show_assigned_tickets"></i>
        <br>
            <input type="checkbox" style="margin-top:10px;" value="1" name="onvacation" <?php echo ($value->onvacation == 1)?"checked":""; ?>>
        <?php } ?>
            <b>Vacation Mode</b>
    </div>
  </div>

  <!-- =================== PREFERENCES ======================== -->

  <div class="hiddens tab_content" id="preferences">
    <div class="col-lg-12" style="border-bottom:1px solid #ddd;">
      <p style="font-size:18px;">Preferences</p>
      <p>Profile preferences and settings</p>
    </div>
    <div class="form-group" style="overflow:auto;margin-top:70px;">
<!--       <label class="col-lg-3 control-label">Maximum Page size</label>
      <div class="col-lg-7">
        <select name="max_page_size" class="form-control">
          <?php foreach ($result->result() as $value) { ?>
            <option value="0" <?php echo ($value->max_page_size == 0)?"selected":""; ?> >— System Default —</option>
            <option value="5" <?php echo ($value->max_page_size == 5)?"selected":""; ?>>show 5 records</option>
            <option value="10" <?php echo ($value->max_page_size == 10)?"selected":""; ?>>show 10 records</option>
            <option value="15" <?php echo ($value->max_page_size == 15)?"selected":""; ?>>show 15 records</option>
            <option value="20" <?php echo ($value->max_page_size == 20)?"selected":""; ?>>show 20 records</option>
            <option value="25" <?php echo ($value->max_page_size == 25)?"selected":""; ?>>show 25 records</option>
            <option value="30" <?php echo ($value->max_page_size == 30)?"selected":""; ?>>show 30 records</option>
            <option value="35" <?php echo ($value->max_page_size == 35)?"selected":""; ?>>show 35 records</option>
            <option value="40" <?php echo ($value->max_page_size == 40)?"selected":""; ?>>show 40 records</option>
            <option value="45" <?php echo ($value->max_page_size == 45)?"selected":""; ?>>show 45 records</option>
            <option value="50" <?php echo ($value->max_page_size == 50)?"selected":""; ?>>show 50 records</option>       
          <?php } ?>
          </select>
      </div>
      <div class="col-lg-2">
        per page.      </div> -->
    </div>
    <div class="form-group" style="overflow:auto;">
      <label class="col-lg-3 control-label">
        Auto Refresh Rate 
        <div class="faded">Tickets page refresh rate in minutes.</div>
      </label>
      <div class="col-lg-9">
        <select name="auto_refresh_rate" class="form-control">
          <?php foreach ($result->result() as $value) { ?>
          <option value="" <?php echo ($value->auto_refresh_rate == "")?"selected":""; ?>>— Disabled —</option>
          <option value="1" <?php echo ($value->auto_refresh_rate == 60)?"selected":""; ?>>Every minute</option>
          <option value="2" <?php echo ($value->auto_refresh_rate == 120)?"selected":""; ?>>Every 2 minutes</option>
          <option value="3" <?php echo ($value->auto_refresh_rate == 180)?"selected":""; ?>>Every 3 minutes</option>
          <option value="4" <?php echo ($value->auto_refresh_rate == 240)?"selected":""; ?>>Every 4 minutes</option>
          <option value="5" <?php echo ($value->auto_refresh_rate == 300)?"selected":""; ?>>Every 5 minutes</option>
          <option value="6" <?php echo ($value->auto_refresh_rate == 360)?"selected":""; ?>>Every 6 minutes</option>
          <option value="7" <?php echo ($value->auto_refresh_rate == 420)?"selected":""; ?>>Every 7 minutes</option>
          <option value="8" <?php echo ($value->auto_refresh_rate == 480)?"selected":""; ?>>Every 8 minutes</option>
          <option value="9" <?php echo ($value->auto_refresh_rate == 540)?"selected":""; ?>>Every 9 minutes</option>
          <option value="10" <?php echo ($value->auto_refresh_rate == 600)?"selected":""; ?>>Every 10 minutes</option>
          <option value="12" <?php echo ($value->auto_refresh_rate == 660)?"selected":""; ?>>Every 12 minutes</option>
          <option value="14" <?php echo ($value->auto_refresh_rate == 720)?"selected":""; ?>>Every 14 minutes</option>
          <option value="16" <?php echo ($value->auto_refresh_rate == 780)?"selected":""; ?>>Every 16 minutes</option>
          <option value="18" <?php echo ($value->auto_refresh_rate == 840)?"selected":""; ?>>Every 18 minutes</option>
          <option value="20" <?php echo ($value->auto_refresh_rate == 900)?"selected":""; ?>>Every 20 minutes</option>
          <option value="22" <?php echo ($value->auto_refresh_rate == 960)?"selected":""; ?>>Every 22 minutes</option>
          <option value="24" <?php echo ($value->auto_refresh_rate == 1020)?"selected":""; ?>>Every 24 minutes</option>
          <option value="26" <?php echo ($value->auto_refresh_rate == 1080)?"selected":""; ?>>Every 26 minutes</option>
          <option value="28" <?php echo ($value->auto_refresh_rate == 1140)?"selected":""; ?>>Every 28 minutes</option>
          <option value="30" <?php echo ($value->auto_refresh_rate == 1200)?"selected":""; ?>>Every 30 minutes</option> 
          <?php } ?>
        </select>
      </div>
    </div>
    <div class="form-group" style="overflow:auto;">
      <label class="col-lg-3 control-label">
        Default From Name        <div class="faded">From name to use when replying to a thread</div>
      </label>
      <div class="col-lg-9">
        <select name="default_from_name" class="form-control" 
        <?php if($hide_staff_name=='1'){
                  echo 'disabled';
          }?>>
          <!-- <option value="" selected="selected">— System Default —</option> -->
          <option value="mine" <?php echo ($value->defaultname == 'mine')?"selected":""; ?> >My Name</option>
          <option value="email" <?php echo ($value->defaultname == 'email')?"selected":""; ?> >Email Address Name</option>
          <option value="dept" <?php echo ($value->defaultname == 'dept')?"selected":""; ?> >Department Name (if public)</option>
        </select>
        <div class="error"></div>
      </div>
    </div>

    <div class="form-group" style="overflow:auto;">
      <label class="col-lg-3 control-label">
        Default Signature:
        <div class="faded">This can be selected when replying to a thread</div>
      </label>

      <div class="col-lg-9">
        <select name="default_signature_type" class="form-control">
          <?php foreach ($result->result() as $value) { ?>
          <option value="none" <?php echo ($value->default_signature_type == 'none')?"selected":""; ?>>— None —</option>
          <option value="mine" <?php echo ($value->default_signature_type == 'mine')?"selected":""; ?>>My Signature</option>
          <option value="dept" <?php echo ($value->default_signature_type == 'dept')?"selected":""; ?>>Department Signature (if set)</option>    
          <?php } ?>    
        </select>
        <div class="error"></div>
      </div>

    </div>
    <!-- <div class="form-group" style="overflow:auto;">
      <label class="col-lg-3 control-label">
          Default Paper Size:
          <div class="faded">Paper size used when printing tickets to PDF</div>
      </label>
      <div class="col-lg-9">
        <select name="default_paper_size" class="form-control">
          <?php foreach ($result->result() as $value) { ?>
            <option value="none" <?php echo ($value->default_paper_size == 'none')?"selected":""; ?>>— None —</option>
            <option value="Letter" <?php echo ($value->default_paper_size == 'Letter')?"selected":""; ?>>Letter</option>
            <option value="Legal" <?php echo ($value->default_paper_size == 'Legal')?"selected":""; ?>>Legal</option>
            <option value="A4" <?php echo ($value->default_paper_size == 'A4')?"selected":""; ?>>A4</option>
            <option value="A3" <?php echo ($value->default_paper_size == 'A3')?"selected":""; ?>>A3</option>   
          <?php } ?>        
        </select>
          <div class="error"></div>
      </div>
    </div> -->
    <div class="col-lg-12" style="border-top:1px solid #ddd;border-bottom:1px solid #ddd;font-size:16px;padding:10px 15px">
      Localization    </div>
    <div class="form-group" style="overflow:auto;margin-top:70px;overflow-y:hidden;">
      <label class="col-lg-3 control-label">Time Zone</label>
      <div class="col-lg-9">
        <select name="timezone" id="timezone-dropdown" class="form-control select2-hidden-accessible" data-placeholder="System Default" tabindex="-1" aria-hidden="true">
        <option value=""></option>
        <option value="Africa/Abidjan">Africa / Abidjan</option>
        <option value="Africa/Accra">Africa / Accra</option>
        <option value="Africa/Addis_Ababa">Africa / Addis_Ababa</option>
        <option value="Africa/Algiers">Africa / Algiers</option>
        <option value="Africa/Asmara">Africa / Asmara</option>
        <option value="Africa/Bamako">Africa / Bamako</option>
        <option value="Africa/Bangui">Africa / Bangui</option>
        <option value="Africa/Banjul">Africa / Banjul</option>
        <option value="Africa/Bissau">Africa / Bissau</option>
        <option value="Africa/Blantyre">Africa / Blantyre</option>
        <option value="Africa/Brazzaville">Africa / Brazzaville</option>
        <option value="Africa/Bujumbura">Africa / Bujumbura</option>
        <option value="Africa/Cairo">Africa / Cairo</option>
        <option value="Africa/Casablanca">Africa / Casablanca</option>
        <option value="Africa/Ceuta">Africa / Ceuta</option>
        <option value="Africa/Conakry">Africa / Conakry</option>
        <option value="Africa/Dakar">Africa / Dakar</option>
        <option value="Africa/Dar_es_Salaam">Africa / Dar_es_Salaam</option>
        <option value="Africa/Djibouti">Africa / Djibouti</option>
        <option value="Africa/Douala">Africa / Douala</option>
        <option value="Africa/El_Aaiun">Africa / El_Aaiun</option>
        <option value="Africa/Freetown">Africa / Freetown</option>
        <option value="Africa/Gaborone">Africa / Gaborone</option>
        <option value="Africa/Harare">Africa / Harare</option>
        <option value="Africa/Johannesburg">Africa / Johannesburg</option>
        <option value="Africa/Juba">Africa / Juba</option>
        <option value="Africa/Kampala">Africa / Kampala</option>
        <option value="Africa/Khartoum">Africa / Khartoum</option>
        <option value="Africa/Kigali">Africa / Kigali</option>
        <option value="Africa/Kinshasa">Africa / Kinshasa</option>
        <option value="Africa/Lagos">Africa / Lagos</option>
        <option value="Africa/Libreville">Africa / Libreville</option>
        <option value="Africa/Lome">Africa / Lome</option>
        <option value="Africa/Luanda">Africa / Luanda</option>
        <option value="Africa/Lubumbashi">Africa / Lubumbashi</option>
        <option value="Africa/Lusaka">Africa / Lusaka</option>
        <option value="Africa/Malabo">Africa / Malabo</option>
        <option value="Africa/Maputo">Africa / Maputo</option>
        <option value="Africa/Maseru">Africa / Maseru</option>
        <option value="Africa/Mbabane">Africa / Mbabane</option>
        <option value="Africa/Mogadishu">Africa / Mogadishu</option>
        <option value="Africa/Monrovia">Africa / Monrovia</option>
        <option value="Africa/Nairobi">Africa / Nairobi</option>
        <option value="Africa/Ndjamena">Africa / Ndjamena</option>
        <option value="Africa/Niamey">Africa / Niamey</option>
        <option value="Africa/Nouakchott">Africa / Nouakchott</option>
        <option value="Africa/Ouagadougou">Africa / Ouagadougou</option>
        <option value="Africa/Porto-Novo">Africa / Porto-Novo</option>
        <option value="Africa/Sao_Tome">Africa / Sao_Tome</option>
        <option value="Africa/Tripoli">Africa / Tripoli</option>
        <option value="Africa/Tunis">Africa / Tunis</option>
        <option value="Africa/Windhoek">Africa / Windhoek</option>
        <option value="America/Adak">America / Adak</option>
        <option value="America/Anchorage">America / Anchorage</option>
        <option value="America/Anguilla">America / Anguilla</option>
        <option value="America/Antigua">America / Antigua</option>
        <option value="America/Araguaina">America / Araguaina</option>
        <option value="America/Argentina/Buenos_Aires">America / Argentina / Buenos_Aires</option>
        <option value="America/Argentina/Catamarca">America / Argentina / Catamarca</option>
        <option value="America/Argentina/Cordoba">America / Argentina / Cordoba</option>
        <option value="America/Argentina/Jujuy">America / Argentina / Jujuy</option>
        <option value="America/Argentina/La_Rioja">America / Argentina / La_Rioja</option>
        <option value="America/Argentina/Mendoza">America / Argentina / Mendoza</option>
        <option value="America/Argentina/Rio_Gallegos">America / Argentina / Rio_Gallegos</option>
        <option value="America/Argentina/Salta">America / Argentina / Salta</option>
        <option value="America/Argentina/San_Juan">America / Argentina / San_Juan</option>
        <option value="America/Argentina/San_Luis">America / Argentina / San_Luis</option>
        <option value="America/Argentina/Tucuman">America / Argentina / Tucuman</option>
        <option value="America/Argentina/Ushuaia">America / Argentina / Ushuaia</option>
        <option value="America/Aruba">America / Aruba</option>
        <option value="America/Asuncion">America / Asuncion</option>
        <option value="America/Atikokan">America / Atikokan</option>
        <option value="America/Bahia">America / Bahia</option>
        <option value="America/Bahia_Banderas">America / Bahia_Banderas</option>
        <option value="America/Barbados">America / Barbados</option>
        <option value="America/Belem">America / Belem</option>
        <option value="America/Belize">America / Belize</option>
        <option value="America/Blanc-Sablon">America / Blanc-Sablon</option>
        <option value="America/Boa_Vista">America / Boa_Vista</option>
        <option value="America/Bogota">America / Bogota</option>
        <option value="America/Boise">America / Boise</option>
        <option value="America/Cambridge_Bay">America / Cambridge_Bay</option>
        <option value="America/Campo_Grande">America / Campo_Grande</option>
        <option value="America/Cancun">America / Cancun</option>
        <option value="America/Caracas">America / Caracas</option>
        <option value="America/Cayenne">America / Cayenne</option>
        <option value="America/Cayman">America / Cayman</option>
        <option value="America/Chicago">America / Chicago</option>
        <option value="America/Chihuahua">America / Chihuahua</option>
        <option value="America/Costa_Rica">America / Costa_Rica</option>
        <option value="America/Creston">America / Creston</option>
        <option value="America/Cuiaba">America / Cuiaba</option>
        <option value="America/Curacao">America / Curacao</option>
        <option value="America/Danmarkshavn">America / Danmarkshavn</option>
        <option value="America/Dawson">America / Dawson</option>
        <option value="America/Dawson_Creek">America / Dawson_Creek</option>
        <option value="America/Denver">America / Denver</option>
        <option value="America/Detroit">America / Detroit</option>
        <option value="America/Dominica">America / Dominica</option>
        <option value="America/Edmonton">America / Edmonton</option>
        <option value="America/Eirunepe">America / Eirunepe</option>
        <option value="America/El_Salvador">America / El_Salvador</option>
        <option value="America/Fort_Nelson">America / Fort_Nelson</option>
        <option value="America/Fortaleza">America / Fortaleza</option>
        <option value="America/Glace_Bay">America / Glace_Bay</option>
        <option value="America/Godthab">America / Godthab</option>
        <option value="America/Goose_Bay">America / Goose_Bay</option>
        <option value="America/Grand_Turk">America / Grand_Turk</option>
        <option value="America/Grenada">America / Grenada</option>
        <option value="America/Guadeloupe">America / Guadeloupe</option>
        <option value="America/Guatemala">America / Guatemala</option>
        <option value="America/Guayaquil">America / Guayaquil</option>
        <option value="America/Guyana">America / Guyana</option>
        <option value="America/Halifax">America / Halifax</option>
        <option value="America/Havana">America / Havana</option>
        <option value="America/Hermosillo">America / Hermosillo</option>
        <option value="America/Indiana/Indianapolis">America / Indiana / Indianapolis</option>
        <option value="America/Indiana/Knox">America / Indiana / Knox</option>
        <option value="America/Indiana/Marengo">America / Indiana / Marengo</option>
        <option value="America/Indiana/Petersburg">America / Indiana / Petersburg</option>
        <option value="America/Indiana/Tell_City">America / Indiana / Tell_City</option>
        <option value="America/Indiana/Vevay">America / Indiana / Vevay</option>
        <option value="America/Indiana/Vincennes">America / Indiana / Vincennes</option>
        <option value="America/Indiana/Winamac">America / Indiana / Winamac</option>
        <option value="America/Inuvik">America / Inuvik</option>
        <option value="America/Iqaluit">America / Iqaluit</option>
        <option value="America/Jamaica">America / Jamaica</option>
        <option value="America/Juneau">America / Juneau</option>
        <option value="America/Kentucky/Louisville">America / Kentucky / Louisville</option>
        <option value="America/Kentucky/Monticello">America / Kentucky / Monticello</option>
        <option value="America/Kralendijk">America / Kralendijk</option>
        <option value="America/La_Paz">America / La_Paz</option>
        <option value="America/Lima">America / Lima</option>
        <option value="America/Los_Angeles">America / Los_Angeles</option>
        <option value="America/Lower_Princes">America / Lower_Princes</option>
        <option value="America/Maceio">America / Maceio</option>
        <option value="America/Managua">America / Managua</option>
        <option value="America/Manaus">America / Manaus</option>
        <option value="America/Marigot">America / Marigot</option>
        <option value="America/Martinique">America / Martinique</option>
        <option value="America/Matamoros">America / Matamoros</option>
        <option value="America/Mazatlan">America / Mazatlan</option>
        <option value="America/Menominee">America / Menominee</option>
        <option value="America/Merida">America / Merida</option>
        <option value="America/Metlakatla">America / Metlakatla</option>
        <option value="America/Mexico_City">America / Mexico_City</option>
        <option value="America/Miquelon">America / Miquelon</option>
        <option value="America/Moncton">America / Moncton</option>
        <option value="America/Monterrey">America / Monterrey</option>
        <option value="America/Montevideo">America / Montevideo</option>
        <option value="America/Montserrat">America / Montserrat</option>
        <option value="America/Nassau">America / Nassau</option>
        <option value="America/New_York">America / New_York</option>
        <option value="America/Nipigon">America / Nipigon</option>
        <option value="America/Nome">America / Nome</option>
        <option value="America/Noronha">America / Noronha</option>
        <option value="America/North_Dakota/Beulah">America / North_Dakota / Beulah</option>
        <option value="America/North_Dakota/Center">America / North_Dakota / Center</option>
        <option value="America/North_Dakota/New_Salem">America / North_Dakota / New_Salem</option>
        <option value="America/Ojinaga">America / Ojinaga</option>
        <option value="America/Panama">America / Panama</option>
        <option value="America/Pangnirtung">America / Pangnirtung</option>
        <option value="America/Paramaribo">America / Paramaribo</option>
        <option value="America/Phoenix">America / Phoenix</option>
        <option value="America/Port-au-Prince">America / Port-au-Prince</option>
        <option value="America/Port_of_Spain">America / Port_of_Spain</option>
        <option value="America/Porto_Velho">America / Porto_Velho</option>
        <option value="America/Puerto_Rico">America / Puerto_Rico</option>
        <option value="America/Rainy_River">America / Rainy_River</option>
        <option value="America/Rankin_Inlet">America / Rankin_Inlet</option>
        <option value="America/Recife">America / Recife</option>
        <option value="America/Regina">America / Regina</option>
        <option value="America/Resolute">America / Resolute</option>
        <option value="America/Rio_Branco">America / Rio_Branco</option>
        <option value="America/Santarem">America / Santarem</option>
        <option value="America/Santiago">America / Santiago</option>
        <option value="America/Santo_Domingo">America / Santo_Domingo</option>
        <option value="America/Sao_Paulo">America / Sao_Paulo</option>
        <option value="America/Scoresbysund">America / Scoresbysund</option>
        <option value="America/Sitka">America / Sitka</option>
        <option value="America/St_Barthelemy">America / St_Barthelemy</option>
        <option value="America/St_Johns">America / St_Johns</option>
        <option value="America/St_Kitts">America / St_Kitts</option>
        <option value="America/St_Lucia">America / St_Lucia</option>
        <option value="America/St_Thomas">America / St_Thomas</option>
        <option value="America/St_Vincent">America / St_Vincent</option>
        <option value="America/Swift_Current">America / Swift_Current</option>
        <option value="America/Tegucigalpa">America / Tegucigalpa</option>
        <option value="America/Thule">America / Thule</option>
        <option value="America/Thunder_Bay">America / Thunder_Bay</option>
        <option value="America/Tijuana">America / Tijuana</option>
        <option value="America/Toronto">America / Toronto</option>
        <option value="America/Tortola">America / Tortola</option>
        <option value="America/Vancouver">America / Vancouver</option>
        <option value="America/Whitehorse">America / Whitehorse</option>
        <option value="America/Winnipeg">America / Winnipeg</option>
        <option value="America/Yakutat">America / Yakutat</option>
        <option value="America/Yellowknife">America / Yellowknife</option>
        <option value="Antarctica/Casey">Antarctica / Casey</option>
        <option value="Antarctica/Davis">Antarctica / Davis</option>
        <option value="Antarctica/DumontDUrville">Antarctica / DumontDUrville</option>
        <option value="Antarctica/Macquarie">Antarctica / Macquarie</option>
        <option value="Antarctica/Mawson">Antarctica / Mawson</option>
        <option value="Antarctica/McMurdo">Antarctica / McMurdo</option>
        <option value="Antarctica/Palmer">Antarctica / Palmer</option>
        <option value="Antarctica/Rothera">Antarctica / Rothera</option>
        <option value="Antarctica/Syowa">Antarctica / Syowa</option>
        <option value="Antarctica/Troll">Antarctica / Troll</option>
        <option value="Antarctica/Vostok">Antarctica / Vostok</option>
        <option value="Arctic/Longyearbyen">Arctic / Longyearbyen</option>
        <option value="Asia/Aden">Asia / Aden</option>
        <option value="Asia/Almaty">Asia / Almaty</option>
        <option value="Asia/Amman">Asia / Amman</option>
        <option value="Asia/Anadyr">Asia / Anadyr</option>
        <option value="Asia/Aqtau">Asia / Aqtau</option>
        <option value="Asia/Aqtobe">Asia / Aqtobe</option>
        <option value="Asia/Ashgabat">Asia / Ashgabat</option>
        <option value="Asia/Atyrau">Asia / Atyrau</option>
        <option value="Asia/Baghdad">Asia / Baghdad</option>
        <option value="Asia/Bahrain">Asia / Bahrain</option>
        <option value="Asia/Baku">Asia / Baku</option>
        <option value="Asia/Bangkok">Asia / Bangkok</option>
        <option value="Asia/Barnaul">Asia / Barnaul</option>
        <option value="Asia/Beirut">Asia / Beirut</option>
        <option value="Asia/Bishkek">Asia / Bishkek</option>
        <option value="Asia/Brunei">Asia / Brunei</option>
        <option value="Asia/Chita">Asia / Chita</option>
        <option value="Asia/Choibalsan">Asia / Choibalsan</option>
        <option value="Asia/Colombo">Asia / Colombo</option>
        <option value="Asia/Damascus">Asia / Damascus</option>
        <option value="Asia/Dhaka">Asia / Dhaka</option>
        <option value="Asia/Dili">Asia / Dili</option>
        <option value="Asia/Dubai">Asia / Dubai</option>
        <option value="Asia/Dushanbe">Asia / Dushanbe</option>
        <option value="Asia/Famagusta">Asia / Famagusta</option>
        <option value="Asia/Gaza">Asia / Gaza</option>
        <option value="Asia/Hebron">Asia / Hebron</option>
        <option value="Asia/Ho_Chi_Minh">Asia / Ho_Chi_Minh</option>
        <option value="Asia/Hong_Kong">Asia / Hong_Kong</option>
        <option value="Asia/Hovd">Asia / Hovd</option>
        <option value="Asia/Irkutsk">Asia / Irkutsk</option>
        <option value="Asia/Jakarta">Asia / Jakarta</option>
        <option value="Asia/Jayapura">Asia / Jayapura</option>
        <option value="Asia/Jerusalem">Asia / Jerusalem</option>
        <option value="Asia/Kabul">Asia / Kabul</option>
        <option value="Asia/Kamchatka">Asia / Kamchatka</option>
        <option value="Asia/Karachi">Asia / Karachi</option>
        <option value="Asia/Kathmandu">Asia / Kathmandu</option>
        <option value="Asia/Khandyga">Asia / Khandyga</option>
        <option value="Asia/Kolkata">Asia / Kolkata</option>
        <option value="Asia/Krasnoyarsk">Asia / Krasnoyarsk</option>
        <option value="Asia/Kuala_Lumpur">Asia / Kuala_Lumpur</option>
        <option value="Asia/Kuching">Asia / Kuching</option>
        <option value="Asia/Kuwait">Asia / Kuwait</option>
        <option value="Asia/Macau">Asia / Macau</option>
        <option value="Asia/Magadan">Asia / Magadan</option>
        <option value="Asia/Makassar">Asia / Makassar</option>
        <option value="Asia/Manila">Asia / Manila</option>
        <option value="Asia/Muscat">Asia / Muscat</option>
        <option value="Asia/Nicosia">Asia / Nicosia</option>
        <option value="Asia/Novokuznetsk">Asia / Novokuznetsk</option>
        <option value="Asia/Novosibirsk">Asia / Novosibirsk</option>
        <option value="Asia/Omsk">Asia / Omsk</option>
        <option value="Asia/Oral">Asia / Oral</option>
        <option value="Asia/Phnom_Penh">Asia / Phnom_Penh</option>
        <option value="Asia/Pontianak">Asia / Pontianak</option>
        <option value="Asia/Pyongyang">Asia / Pyongyang</option>
        <option value="Asia/Qatar">Asia / Qatar</option>
        <option value="Asia/Qyzylorda">Asia / Qyzylorda</option>
        <option value="Asia/Riyadh">Asia / Riyadh</option>
        <option value="Asia/Sakhalin">Asia / Sakhalin</option>
        <option value="Asia/Samarkand">Asia / Samarkand</option>
        <option value="Asia/Seoul">Asia / Seoul</option>
        <option value="Asia/Shanghai">Asia / Shanghai</option>
        <option value="Asia/Singapore">Asia / Singapore</option>
        <option value="Asia/Srednekolymsk">Asia / Srednekolymsk</option>
        <option value="Asia/Taipei">Asia / Taipei</option>
        <option value="Asia/Tashkent">Asia / Tashkent</option>
        <option value="Asia/Tbilisi">Asia / Tbilisi</option>
        <option value="Asia/Tehran">Asia / Tehran</option>
        <option value="Asia/Thimphu">Asia / Thimphu</option>
        <option value="Asia/Tokyo">Asia / Tokyo</option>
        <option value="Asia/Tomsk">Asia / Tomsk</option>
        <option value="Asia/Ulaanbaatar">Asia / Ulaanbaatar</option>
        <option value="Asia/Urumqi">Asia / Urumqi</option>
        <option value="Asia/Ust-Nera">Asia / Ust-Nera</option>
        <option value="Asia/Vientiane">Asia / Vientiane</option>
        <option value="Asia/Vladivostok">Asia / Vladivostok</option>
        <option value="Asia/Yakutsk">Asia / Yakutsk</option>
        <option value="Asia/Yangon">Asia / Yangon</option>
        <option value="Asia/Yekaterinburg">Asia / Yekaterinburg</option>
        <option value="Asia/Yerevan">Asia / Yerevan</option>
        <option value="Atlantic/Azores">Atlantic / Azores</option>
        <option value="Atlantic/Bermuda">Atlantic / Bermuda</option>
        <option value="Atlantic/Canary">Atlantic / Canary</option>
        <option value="Atlantic/Cape_Verde">Atlantic / Cape_Verde</option>
        <option value="Atlantic/Faroe">Atlantic / Faroe</option>
        <option value="Atlantic/Madeira">Atlantic / Madeira</option>
        <option value="Atlantic/Reykjavik">Atlantic / Reykjavik</option>
        <option value="Atlantic/South_Georgia">Atlantic / South_Georgia</option>
        <option value="Atlantic/St_Helena">Atlantic / St_Helena</option>
        <option value="Atlantic/Stanley">Atlantic / Stanley</option>
        <option value="Australia/Adelaide">Australia / Adelaide</option>
        <option value="Australia/Brisbane">Australia / Brisbane</option>
        <option value="Australia/Broken_Hill">Australia / Broken_Hill</option>
        <option value="Australia/Currie">Australia / Currie</option>
        <option value="Australia/Darwin">Australia / Darwin</option>
        <option value="Australia/Eucla">Australia / Eucla</option>
        <option value="Australia/Hobart">Australia / Hobart</option>
        <option value="Australia/Lindeman">Australia / Lindeman</option>
        <option value="Australia/Lord_Howe">Australia / Lord_Howe</option>
        <option value="Australia/Melbourne">Australia / Melbourne</option>
        <option value="Australia/Perth">Australia / Perth</option>
        <option value="Australia/Sydney">Australia / Sydney</option>
        <option value="Europe/Amsterdam">Europe / Amsterdam</option>
        <option value="Europe/Andorra">Europe / Andorra</option>
        <option value="Europe/Astrakhan">Europe / Astrakhan</option>
        <option value="Europe/Athens">Europe / Athens</option>
        <option value="Europe/Belgrade">Europe / Belgrade</option>
        <option value="Europe/Berlin">Europe / Berlin</option>
        <option value="Europe/Bratislava">Europe / Bratislava</option>
        <option value="Europe/Brussels">Europe / Brussels</option>
        <option value="Europe/Bucharest">Europe / Bucharest</option>
        <option value="Europe/Budapest">Europe / Budapest</option>
        <option value="Europe/Busingen">Europe / Busingen</option>
        <option value="Europe/Chisinau">Europe / Chisinau</option>
        <option value="Europe/Copenhagen">Europe / Copenhagen</option>
        <option value="Europe/Dublin">Europe / Dublin</option>
        <option value="Europe/Gibraltar">Europe / Gibraltar</option>
        <option value="Europe/Guernsey">Europe / Guernsey</option>
        <option value="Europe/Helsinki">Europe / Helsinki</option>
        <option value="Europe/Isle_of_Man">Europe / Isle_of_Man</option>
        <option value="Europe/Istanbul">Europe / Istanbul</option>
        <option value="Europe/Jersey">Europe / Jersey</option>
        <option value="Europe/Kaliningrad">Europe / Kaliningrad</option>
        <option value="Europe/Kiev">Europe / Kiev</option>
        <option value="Europe/Kirov">Europe / Kirov</option>
        <option value="Europe/Lisbon">Europe / Lisbon</option>
        <option value="Europe/Ljubljana">Europe / Ljubljana</option>
        <option value="Europe/London">Europe / London</option>
        <option value="Europe/Luxembourg">Europe / Luxembourg</option>
        <option value="Europe/Madrid">Europe / Madrid</option>
        <option value="Europe/Malta">Europe / Malta</option>
        <option value="Europe/Mariehamn">Europe / Mariehamn</option>
        <option value="Europe/Minsk">Europe / Minsk</option>
        <option value="Europe/Monaco">Europe / Monaco</option>
        <option value="Europe/Moscow">Europe / Moscow</option>
        <option value="Europe/Oslo">Europe / Oslo</option>
        <option value="Europe/Paris">Europe / Paris</option>
        <option value="Europe/Podgorica">Europe / Podgorica</option>
        <option value="Europe/Prague">Europe / Prague</option>
        <option value="Europe/Riga">Europe / Riga</option>
        <option value="Europe/Rome">Europe / Rome</option>
        <option value="Europe/Samara">Europe / Samara</option>
        <option value="Europe/San_Marino">Europe / San_Marino</option>
        <option value="Europe/Sarajevo">Europe / Sarajevo</option>
        <option value="Europe/Saratov">Europe / Saratov</option>
        <option value="Europe/Simferopol">Europe / Simferopol</option>
        <option value="Europe/Skopje">Europe / Skopje</option>
        <option value="Europe/Sofia">Europe / Sofia</option>
        <option value="Europe/Stockholm">Europe / Stockholm</option>
        <option value="Europe/Tallinn">Europe / Tallinn</option>
        <option value="Europe/Tirane">Europe / Tirane</option>
        <option value="Europe/Ulyanovsk">Europe / Ulyanovsk</option>
        <option value="Europe/Uzhgorod">Europe / Uzhgorod</option>
        <option value="Europe/Vaduz">Europe / Vaduz</option>
        <option value="Europe/Vatican">Europe / Vatican</option>
        <option value="Europe/Vienna">Europe / Vienna</option>
        <option value="Europe/Vilnius">Europe / Vilnius</option>
        <option value="Europe/Volgograd">Europe / Volgograd</option>
        <option value="Europe/Warsaw">Europe / Warsaw</option>
        <option value="Europe/Zagreb">Europe / Zagreb</option>
        <option value="Europe/Zaporozhye">Europe / Zaporozhye</option>
        <option value="Europe/Zurich">Europe / Zurich</option>
        <option value="Indian/Antananarivo">Indian / Antananarivo</option>
        <option value="Indian/Chagos">Indian / Chagos</option>
        <option value="Indian/Christmas">Indian / Christmas</option>
        <option value="Indian/Cocos">Indian / Cocos</option>
        <option value="Indian/Comoro">Indian / Comoro</option>
        <option value="Indian/Kerguelen">Indian / Kerguelen</option>
        <option value="Indian/Mahe">Indian / Mahe</option>
        <option value="Indian/Maldives">Indian / Maldives</option>
        <option value="Indian/Mauritius">Indian / Mauritius</option>
        <option value="Indian/Mayotte">Indian / Mayotte</option>
        <option value="Indian/Reunion">Indian / Reunion</option>
        <option value="Pacific/Apia">Pacific / Apia</option>
        <option value="Pacific/Auckland">Pacific / Auckland</option>
        <option value="Pacific/Bougainville">Pacific / Bougainville</option>
        <option value="Pacific/Chatham">Pacific / Chatham</option>
        <option value="Pacific/Chuuk">Pacific / Chuuk</option>
        <option value="Pacific/Easter">Pacific / Easter</option>
        <option value="Pacific/Efate">Pacific / Efate</option>
        <option value="Pacific/Enderbury">Pacific / Enderbury</option>
        <option value="Pacific/Fakaofo">Pacific / Fakaofo</option>
        <option value="Pacific/Fiji">Pacific / Fiji</option>
        <option value="Pacific/Funafuti">Pacific / Funafuti</option>
        <option value="Pacific/Galapagos">Pacific / Galapagos</option>
        <option value="Pacific/Gambier">Pacific / Gambier</option>
        <option value="Pacific/Guadalcanal">Pacific / Guadalcanal</option>
        <option value="Pacific/Guam">Pacific / Guam</option>
        <option value="Pacific/Honolulu">Pacific / Honolulu</option>
        <option value="Pacific/Johnston">Pacific / Johnston</option>
        <option value="Pacific/Kiritimati">Pacific / Kiritimati</option>
        <option value="Pacific/Kosrae">Pacific / Kosrae</option>
        <option value="Pacific/Kwajalein">Pacific / Kwajalein</option>
        <option value="Pacific/Majuro">Pacific / Majuro</option>
        <option value="Pacific/Marquesas">Pacific / Marquesas</option>
        <option value="Pacific/Midway">Pacific / Midway</option>
        <option value="Pacific/Nauru">Pacific / Nauru</option>
        <option value="Pacific/Niue">Pacific / Niue</option>
        <option value="Pacific/Norfolk">Pacific / Norfolk</option>
        <option value="Pacific/Noumea">Pacific / Noumea</option>
        <option value="Pacific/Pago_Pago">Pacific / Pago_Pago</option>
        <option value="Pacific/Palau">Pacific / Palau</option>
        <option value="Pacific/Pitcairn">Pacific / Pitcairn</option>
        <option value="Pacific/Pohnpei">Pacific / Pohnpei</option>
        <option value="Pacific/Port_Moresby">Pacific / Port_Moresby</option>
        <option value="Pacific/Rarotonga">Pacific / Rarotonga</option>
        <option value="Pacific/Saipan">Pacific / Saipan</option>
        <option value="Pacific/Tahiti">Pacific / Tahiti</option>
        <option value="Pacific/Tarawa">Pacific / Tarawa</option>
        <option value="Pacific/Tongatapu">Pacific / Tongatapu</option>
        <option value="Pacific/Wake">Pacific / Wake</option>
        <option value="Pacific/Wallis">Pacific / Wallis</option>
        <option value="UTC">UTC</option>
    </select>
    <button type="button" class="action-button" onclick="javascript:
$('head').append($('<script>').attr('src', '/helpdesk/js/jstz.min.js'));
var recheck = setInterval(function() {
    if (window.jstz !== undefined) {
        clearInterval(recheck);
        var zone = jstz.determine();
        $('#timezone-dropdown').val(zone.name()).trigger('change');

    }
}, 100);
return false;" style="vertical-align:middle"><i class="icon-map-marker"></i> Auto Detect</button>

<script type="text/javascript">
$(function() {
    $('#timezone-dropdown').select2({
        allowClear: true,
        width: '300px'
    });
});
</script>
        <div class="error"></div>
      </div>
    </div>
    <div class="form-group" style="overflow:auto;">
      <label class="col-lg-3 control-label">Time Format</label>
      <div class="col-lg-9">
        <select name="datetime_format">
                          <option value="relative">Relative Time</option>
                          <option value="" selected="selected">— System Default —</option>
                    </select>
      </div>
    </div>
          </div>

  <!-- ==================== SIGNATURES ======================== -->

  <div id="signature" class="hiddens">
    <table class="table two-column" width="100%">
      <tbody>
        <tr class="header">
          <th colspan="2">
            Signature            <div><small>Optional signature used on outgoing emails. Signature is made available as a choice, on ticket reply.            </small></div>
          </th>
        </tr>
        <tr>
            <td colspan="2">

            <div class="box">
            <div class="box-header">

              <!-- tools box -->
              <div class="pull-right box-tools">

              </div>
              <!-- /. tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body pad">
                
                <textarea name="signature" class="textarea" placeholder="Place some text here"
                          style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"><?php foreach ($result->result() as $value) { ?> <?php echo $value->signature ?> <?php } ?></textarea>
                
              
            </div>
            </div>

            </td>
        </tr>
      </tbody>
    </table>
  </div>

  <p style="text-align:center;">
    <button class="button action-button" type="submit" name="submit"><i class="icon-save"></i> Save Changes</button>
    <button class="button action-button" type="reset" name="reset"><i class="icon-undo"></i>
        Reset</button>
    <button class="red button action-button" type="button" name="cancel" onclick="window.history.go(-1);"><i class="icon-remove-circle"></i> Cancel</button>
  </p>
    <div class="clear"></div>
</form>
</div>
</div>
 

<!-- change password popup modal -->
<div class="modal fade" id="cpass-modal" style="display: none;">
          <div class="modal-dialog">
            <form method="post" action="<?php echo site_url('staff_dashboard_controller/passwordchange')?>">
            <div class="modal-content">
              <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">×</span></button>
                    <h3 class="drag-handle">Change Password</h3>
              </div>
              <div class="modal-body">

                
                  <div class="quick-add">
                          <table class="grid form">
                          <caption>                  <div><small>Confirm your current password and enter a new password to continue</small></div>
                          </caption>
                          <tbody><tr><td style="width:8.3333%"></td><td style="width:8.3333%"></td><td style="width:8.3333%"></td><td style="width:8.3333%"></td><td style="width:8.3333%"></td><td style="width:8.3333%"></td><td style="width:8.3333%"></td><td style="width:8.3333%"></td><td style="width:8.3333%"></td><td style="width:8.3333%"></td><td style="width:8.3333%"></td><td style="width:8.3333%"></td></tr></tbody>
                <tbody><tr>          <td class="cell" colspan="12" rowspan="1" style="" data-field-id="1">
                              <fieldset class="field " id="field_bc35d1a37d90ade1" data-field-id="1">
                        <input type="password" class="form-control" id="_bc35d1a37d90ade1" size="16" maxlength="30" placeholder="Current Password" autofocus="" name="currentpass" value="">
                                      </fieldset>
                          </td>
                      </tr><tr>          <td class="cell" colspan="12" rowspan="1" style="padding-top: 20px" data-field-id="2">
                              <fieldset class="field " id="field_bb52363f4565e4ca" data-field-id="2">
                              <label class="required" for="_bb52363f4565e4ca">
                                  Enter a new password:
                                                <span class="error">*</span>
                                              </label>
                        <input type="password" class="form-control" id="_bb52363f4565e4ca" size="16" maxlength="30" placeholder="New Password" name="newpass1" value="">
                                      </fieldset>
                          </td>
                      </tr><tr>          <td class="cell" colspan="12" rowspan="1" style="" data-field-id="3">
                              <fieldset class="field " id="field_35097ac295cd7734" data-field-id="3">
                        <input type="password" class="form-control" id="_35097ac295cd7734" size="16" maxlength="30" placeholder="Confirm Password" name="newpass2" value="">
                                      </fieldset>
                          </td>
                      </tr></tbody></table>  </div>
                  <hr>

                  <div class="clear"></div>
                

              </div>

                <div class="modal-footer">
 
                  <p class="full-width">
                    <span class="buttons pull-left">
                      <input type="reset" value="Reset">
                      <input type="button" name="cancel" class="close" value="Cancel">
                    </span>
                    <span class="buttons pull-right">
                      <input type="submit" value="Update">
                    </span>
                  </p>
                </div>

            </div>
            <!-- /.modal-content -->
            </form>
          </div>
          <!-- /.modal-dialog -->
</div>
<!-- change password popup modal -->