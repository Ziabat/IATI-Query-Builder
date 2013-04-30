<?php
//print_r($_POST);

if (isset($_POST)) {

  $allowed_datasets = array("activities","transactions","budgets");
  if (isset($_POST["entry_1085079344"])) { //dataset
    $requested_dataset = filter_var($_POST["entry_1085079344"], FILTER_SANITIZE_STRING);
    if (in_array($requested_dataset, $allowed_datasets)) {
      $dataset = $requested_dataset;
    }
  }
  
  $allowed_formats = array("summary","by_sector","by_country");
  if (isset($_POST["entry_71167035"])) { //format
    $requested_format = filter_var($_POST["entry_71167035"], FILTER_SANITIZE_STRING);
    if (in_array($requested_format, $allowed_formats)) {
      $format = $requested_format;
    }
  }
  $allowed_sizes = array("50 rows","Entire selection");
  if (isset($_POST["entry_1352830161"])) { //sample size
    $requested_size = filter_var($_POST["entry_1352830161"], FILTER_SANITIZE_STRING);
    if (in_array($requested_size, $allowed_sizes)) {
      $size = $requested_size;
    if ($size == "Entire selection" ) {
        $size = "stream=True";
      }
    }
  }
  
  $allowed_orgs = array();
  if (isset($_POST["entry_1922375458"])) { //organisations
    $requested_org = filter_var($_POST["entry_1922375458"], FILTER_SANITIZE_STRING);
    if (!in_array($requested_org, $allowed_orgs) && $requested_org != NULL) { //!!!!FIX ME!!!!
      $org = $requested_org;
    }
  }

  $allowed_types = array();
  if (isset($_POST["entry_18398991"])) { //organisations
    $requested_type = filter_var($_POST["entry_18398991"], FILTER_SANITIZE_STRING);
    if (!in_array($requested_type, $allowed_types) && $requested_type != NULL) { //!!!!FIX ME!!!!
      $type = $requested_type;
    }
  }

  $allowed_sectors = array();
  if (isset($_POST["entry_1954968791"])) { //organisations
    $requested_sector = filter_var($_POST["entry_1954968791"], FILTER_SANITIZE_STRING);
    if (!in_array($requested_sector, $allowed_types) && $requested_sector != NULL) { //!!!!FIX ME!!!!
      $sector = $requested_sector;
    }
  }

  $allowed_countries = array();
  if (isset($_POST["entry_605980212"])) { //organisations
    $requested_country = filter_var($_POST["entry_605980212"], FILTER_SANITIZE_STRING);
    if (!in_array($requested_country, $allowed_types) && $requested_country != NULL) { //!!!!FIX ME!!!!
      $country = $requested_country;
    }
  }
  
  $allowed_regions = array();
  if (isset($_POST["entry_1179181326"])) { //organisations
    $requested_region = filter_var($_POST["entry_1179181326"], FILTER_SANITIZE_STRING);
    if (!in_array($requested_region, $allowed_types)&& $requested_region != NULL) { //!!!!FIX ME!!!!
      $region = $requested_region;
    }
  }
  if (isset($dataset) && isset($format) && isset($size)) {
   //&& isset($org) && isset($type) && isset($sector) && (isset($country) || isset($region)) ) {
    $api_link = "http://iati-datastore.herokuapp.com/";
    $api_link .= "api/1/access/";
    $api_link .= $dataset . ".csv";
   //echo $api_link;
    if (isset($org) || isset($type) || isset($sector) || (isset($country) || isset($region)) ) {
      $api_link .= "?";
      $api_link_parameters = array();
      if (isset($org)) {
        $api_link_parameters ["reporting-org"] = $org;
      }
      if (isset($type)) {
        $api_link_parameters ["reporting-org_type"] = $type;
      }
      if (isset($sector)) {
        $api_link_parameters ["sector"] = $sector;
      }
      if (isset($country) && !isset($region)) {
        $api_link_parameters ["recipient-country"] = $country;
      }
      if (isset($region) && !isset($country)) {
        $api_link_parameters ["recipient-region"] = $region;
      }
      if ($size == "stream=True") {
        $api_link_parameters ["stream"] = "True";
      }
      $api_link .= http_build_query($api_link_parameters);
    }
  } else {
    $error_message = "You must select something from each of the 3 required fields";
  }
}
/*DEBUG
echo  "<br/>";
echo $dataset . "<br/>";
echo $format . "<br/>";
echo $requested_size . "<br/>";
echo $org . "<br/>";
echo $type . "<br/>";
echo $sector . "<br/>";
echo $country . "<br/>";
echo $region . "<br/>";
*/
?>

<html>
  <head>
    <title>IATI Data Store CSV Query</title>
    <link href='style.css' type='text/css' rel='stylesheet'>
  </head>
<body dir="ltr" class="ss-base-body">
  <div itemscope itemtype="http://schema.org/CreativeWork/FormObject">
    <div class="ss-form-container">
      <div class="ss-top-of-page">
        <div class="ss-form-heading">
          <h1 class="ss-form-title" dir="ltr">IATI Data Store CSV Query</h1>
          <hr class="ss-email-break" style="display:none;">
          <?php
            if (isset($api_link)) {
          ?>
          <div class="url">
            <p>Your link:<br/>
              <a href="<?php echo $api_link; ?>"><?php echo htmlspecialchars($api_link); ?></a>
            </p>
          </div>
          <?php
           } elseif (isset($error_message)) {
          ?>
          <div class="errorbox-bad">
            <?php echo $error_message; ?>
          </div>
           <?php
           } 
          ?>
          <div class="ss-required-asterisk">*Required</div>
        </div>
      </div>
      <div class="ss-form">
        <form action="index.php" method="POST" id="ss-form" target="_self" onsubmit="">
          <div class="errorbox-good">
            <div dir="ltr" class="ss-item ss-item-required ss-radio">
              <div class="ss-form-entry">
                <label class="ss-q-item-label" for="entry_1689841214">
                  <div class="ss-q-title">Choose Dataset
                    <label for="itemView.getDomIdToLabel()" aria-label="(Required field)"></label>
                      <span class="ss-required-asterisk">*</span></div>
                    </label>
                    <ul class="ss-choices">
                      <li class="ss-choice-item">
                        <label>
                          <input type="radio" name="entry.1085079344" value="activities" id="group_1085079344_1" class="ss-q-radio" aria-label="Activities">
                            <span class="ss-choice-label">Activities</span>
                          </label>
                        </li>
                        <li class="ss-choice-item">
                          <label>
                            <input type="radio" name="entry.1085079344" value="transactions" id="group_1085079344_2" class="ss-q-radio" aria-label="Transactions">
                            <span class="ss-choice-label">Transactions</span>
                          </label>
                        </li>
                        <li class="ss-choice-item">
                          <label>
                            <input type="radio" name="entry.1085079344" value="budgets" id="group_1085079344_3" class="ss-q-radio" aria-label="Budgets">
                            <span class="ss-choice-label">Budgets</span>
                          </label>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div> 
                <div class="errorbox-good">
                  <div dir="ltr" class="ss-item ss-item-required ss-radio">
                    <div class="ss-form-entry">
                      <label class="ss-q-item-label" for="entry_1948547450">
                        <div class="ss-q-title">Choose Dataset Format
                          <label for="itemView.getDomIdToLabel()" aria-label="(Required field)"></label>
                          <span class="ss-required-asterisk">*</span>
                        </div>
                      </label>
                      <ul class="ss-choices">
                        <li class="ss-choice-item">
                          <label>
                            <input type="radio" name="entry.71167035" value="summary" id="group_71167035_1" class="ss-q-radio" aria-label="Summary">
                            <span class="ss-choice-label">Summary</span>
                          </label>
                        </li>
                        <li class="ss-choice-item">
                          <label>
                            <input type="radio" name="entry.71167035" value="by_sector" id="group_71167035_2" class="ss-q-radio" aria-label="By Sector">
                            <span class="ss-choice-label">By Sector</span>
                          </label>
                        </li>
                        <li class="ss-choice-item">
                          <label>
                            <input type="radio" name="entry.71167035" value="by_country" id="group_71167035_3" class="ss-q-radio" aria-label="By Country">
                            <span class="ss-choice-label">By Country</span>
                          </label>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
                <div class="errorbox-good">
                <div dir="ltr" class="ss-item ss-item-required ss-radio">
                    <div class="ss-form-entry">
                      <label class="ss-q-item-label" for="entry_1414120858">
                        <div class="ss-q-title">Choose Sample Size
                          <label for="itemView.getDomIdToLabel()" aria-label="(Required field)"></label>
                          <span class="ss-required-asterisk">*</span>
                        </div>
                      </label>
                      <ul class="ss-choices">
                        <li class="ss-choice-item">
                          <label>
                            <input type="radio" name="entry.1352830161" value="50 rows" id="group_1352830161_1" class="ss-q-radio" aria-label="50 rows">
                            <span class="ss-choice-label">50 rows</span>
                          </label>
                        </li>
                        <li class="ss-choice-item">
                          <label>
                            <input type="radio" name="entry.1352830161" value="Entire selection" id="group_1352830161_2" class="ss-q-radio" aria-label="Entire selection">
                            <span class="ss-choice-label">Entire selection</span>
                          </label>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
                <div class="errorbox-good">
                  <div dir="ltr" class="ss-item  ss-text">
                    <div class="ss-form-entry">
                      <label class="ss-q-item-label" for="entry_1922375458">
                        <div class="ss-q-title">Select Reporting Organisation <span class="ss-q-help ss-secondary-text">(eg UK DFID = GB-1)</span></div>
                        <div class="ss-q-help ss-secondary-text" dir="ltr"></div>
                      </label>
                      <select name="entry.1922375458" value="" class="ss-q-short" id="entry_1922375458">
                        <?php include("include/reporting_org.php"); ?>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="errorbox-good">
                  <div dir="ltr" class="ss-item  ss-text">
                    <div class="ss-form-entry">
                      <label class="ss-q-item-label" for="entry_18398991">
                        <div class="ss-q-title">Select Type of Reporting Organisation</div>
                        <div class="ss-q-help ss-secondary-text" dir="ltr">(eg. INGO = 21)</div>
                      </label>
                      <input type="text" name="entry.18398991" value="" class="ss-q-short" id="entry_18398991" dir="auto">
                    </div>
                  </div>
                </div>
                <div class="errorbox-good">
                <div dir="ltr" class="ss-item  ss-text">
                  <div class="ss-form-entry">
                    <label class="ss-q-item-label" for="entry_1954968791">
                      <div class="ss-q-title">Select Sector</div>
                      <div class="ss-q-help ss-secondary-text" dir="ltr">(eg Basic Health Care = 12220)</div></label>
                      <input type="text" name="entry.1954968791" value="" class="ss-q-short" id="entry_1954968791" dir="auto">
                    </div>
                  </div>
                </div>
                <div class="errorbox-good">
                  <div dir="ltr" class="ss-item  ss-text">
                    <div class="ss-form-entry">
                      <label class="ss-q-item-label" for="entry_605980212">
                        <div class="ss-q-title">Select Country</div>
                        <div class="ss-q-help ss-secondary-text" dir="ltr">(eg DRC = CD)</div>
                      </label>
                      <input type="text" name="entry.605980212" value="" class="ss-q-short" id="entry_605980212" dir="auto">
                    </div>
                  </div>
                </div>
                <div class="errorbox-good">
                  <div dir="ltr" class="ss-item  ss-text">
                    <div class="ss-form-entry">
                      <label class="ss-q-item-label" for="entry_1179181326">
                        <div class="ss-q-title">Select Region</div>
                        <div class="ss-q-help ss-secondary-text" dir="ltr">(eg South Asia = 679)</div></label>
                        <input type="text" name="entry.1179181326" value="" class="ss-q-short" id="entry_1179181326" dir="auto">
                      </div>
                    </div>
                  </div>
                  <!--<input type="hidden" name="draftResponse" value="[]">
                  <input type="hidden" name="pageHistory" value="0">-->


                  <div class="ss-item ss-navigate">
                    <div class="ss-form-entry">
                      <input type="submit" name="submit" value="Submit" id="ss-submit">
                    </div>
                  </div>
                </form>
              </div>
              <div class="ss-footer">
                <div class="ss-attribution"></div>
                <div class="ss-legal">
                  <div class="disclaimer-separator"></div>
                  <div class="disclaimer">
                    <div class="powered-by-logo"></div>
                    <div class="ss-terms"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </body>
      </html>
