<?php

namespace App\Console\Commands;

use DB;
use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;

class ML4AfrikaSeed extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */

             /** action(s) **\
              |    seed     |
              | getmappings |
              | getesttypes |
              |    store    |
              |   update    |
              |   destroy   |
             \**            **/         
  protected $signature = 'ml4afrika:seed';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Command description';

  /**
   * Create a new command instance.
   *
   * @return void
   */
  public function __construct()
  {
      parent::__construct();
  }

  /**
   * Execute the console command.
   *
   * @return mixed
   */
  public function handle()
  {
    $testTypes = [
      [
        "data_element_id" => "preg_test_results",
        "blis_alias" => "Pregnancy test",
        "name" => "Pregnancy Test Results",
        "result" => ["Positive","Negative","Inconclusive"],
        "additionals" => [
          [
            "data_element_id" => "preg_test",
            "name" => "Pregnancy Test Requested",
            "result" => ["Not appropriate","Yes","No"],
            "type" => "requested",
          ],
          [
            "data_element_id" => "preg_test_results_details",
            "name" => "Pregnancy Test Results Details",
            "result" => ["Text"],
            "type" => "details",
          ],
          [
            "data_element_id" => "preg_test_results_no",
            "name" => "Pregnancy Test Results No",
            "result" => ["Text"],
            "type" => "number",
          ],
          [
            "data_element_id" => "preg_test_results_date",
            "name" => "Date Pregnancy Test Results Received",
            "result" => ["Date"],
            "type" => "date",
          ],
        ]
      ],
      [
        "data_element_id" => "anc_hb_test_results",
        "blis_alias" => "HB",
        "name" => "HB Test Results",
        "result" => ["Positive", "Negative", "Not Available"],
        "additionals" => [
          [
            "data_element_id" => "anc_hb_test",
            "name" => "HB Test Undertaken",
            "result" => ["Tested onsite", "Blood sent away", "No"],
            "type" => "requested",
          ],
          [
            "data_element_id" => "anc_hb_test_results_date",
            "name" => "HB Test Results Date",
            "result" => ["Date"],
            "type" => "date",
          ],
          [
            "data_element_id" => "anc_hb_test_results_no",
            "name" => "HB Test Results No",
            "result" => ["Text"],
            "type" => "number",
          ],
        ]
      ],
      [
        "data_element_id" => "scr_hb_test_results_gdl",
        "blis_alias" => "HB",
        "name" => "HB (g/dl)",
        "result" => ["Number"],
      ],
      [
        "data_element_id" => "anc_rh_test_results",
        "blis_alias" => "",
        "name" => "RH Test Results",
        "result" => ["Rh Positive / Rh Negative"],
        "additionals" => [
          [
            "data_element_id" => "anc_rh_test",
            "name" => "Rapid Rhesus Blood Group Test Undertaken",
            "result" => ["Yes","No"],
            "type" => "requested",
          ],
          [
            "data_element_id" => "anc_rh_test_results_details",
            "name" => "Rhesus Factor Test Results Details",
            "result" => ["Text"],
            "type" => "details",
          ],
          [
            "data_element_id" => "anc_rh_test_results_no",
            "name" => "Rhesus Test Record Number",
            "result" => ["Text"],
            "type" => "number",
          ],
          [
            "data_element_id" => "scr_rhesus_test_results_date",
            "name" => "Rhesus Test Results Date",
            "result" => ["Date"],
            "type" => "date",
          ],
        ]
      ],
      [
        "data_element_id" => "scr_urine_test_results",
        "blis_alias" => "",//what test exactly is required here
        "name" => "Test Results",
        "result" => ["Text"],
        "additionals" => [
          [
            "data_element_id" => "scr_urine_test",
            "name" => "Urine Test Undertaken",
            "result" => ["Yes","No"],
            "type" => "requested",
          ],
          [
            "data_element_id" => "scr_urine_test_details",
            "name" => "Details on what urine was tested for ",
            "result" => ["Text"],
            "type" => "details",
          ],
          [
            "data_element_id" => "scr_urine_test_results_no",
            "name" => "Test Results Number",
            "result" => ["Text"],
            "type" => "number",
          ],
          [
            "data_element_id" => "scr_urine_test_results_date",
            "name" => "Urine Test Results Date",
            "result" => ["Date"],
            "type" => "date",
          ],
        ]
      ],
      [
        "data_element_id" => "scr_urine_protein_test_results",
        "blis_alias" => "",//what test exactly is required here
        "name" => "Protein Test Results",
        "result" => ["+1 (urinary tract infection)", "+2 (pre-eclampsia)", "+3 (eclampsia)", "+4"],
        "additionals" => [
          [
            "data_element_id" => "scr_urine_protein_test",
            "name" => "Protein Test Normal",
            "result" => ["Yes","No"],
            "type" => "requested",
          ],
          [
            "data_element_id" => "scr_urine_protein_test_results_date",
            "name" => "Protein Test Results Received",
            "result" => ["Date"],
            "type" => "date",
          ],
          [
            "data_element_id" => "scr_urine_treatment",
            "name" => "Treatment",
            "result" => ["Text"],
            "type" => "details",
          ],
        ]
      ],
      [
        "data_element_id" => "scr_urine_sugar_test",
        "blis_alias" => "",////what test exactly is required here - only blood sugar on the menu
        "name" => "Urine Sugar Test Normal",
        "result" => ["Yes","No"],// todo: results is a number this complicates things
      ],
      [
        "data_element_id" => "scr_urine_puss_cell_test_results",
        "blis_alias" => "",//what test exactly is required here
        "name" => "Puss Cell Test Results",
        "result" => ["Text"],
        "additionals" => [
          [
            "data_element_id" => "scr_urine_puss_cell_test",
            "name" => "Tested for Puss Cell",
            "result" => ["Yes","No"],
            "type" => "requested",
          ],
          [
            "data_element_id" => "scr_urine_puss_cell_test_results_date",
            "name" => "Puss Cell Test Results Received",
            "result" => ["Date"],
            "type" => "date",
          ],
        ]
      ],
      [
        "data_element_id" => "scr_epithelialcell_test_results",
        "blis_alias" => "",//what test exactly is required here
        "name" => "Epithelial Cell Test Results",
        "result" => ["Text"],
        "additionals" => [
          [
            "data_element_id" => "scr_epithelialcell_test",
            "name" => "Tested for Epithelial Cells",
            "result" => ["Yes","No"],
            "type" => "requested",
          ],
          [
            "data_element_id" => "scr_epithelialcell_test_results_date",
            "name" => "Epithelial  Cell Test Results Received",
            "result" => ["Date"],
            "type" => "date",
          ],
        ]
      ],
      [
        "data_element_id" => "anc_urine_infection_test_results",
        "blis_alias" => "",//what test exactly is required here
        "name" => "Urine Bacterial Infection Test Results",
        "result" => ["Text"],
        "additionals" => [
          [
            "data_element_id" => "anc_urine_infection_test",
            "name" => "Tested for Baterial Infection",
            "result" => ["Yes","No"],
            "type" => "requested",
          ],
          [
            "data_element_id" => "anc_urine_infection_test_results_date",
            "name" => "Urine Bacterial Infection Test Results Received",
            "result" => ["Date"],
            "type" => "date",
          ],
          [
            "data_element_id" => "anc_urine_tract_infection",
            "name" => "Evidence of Urinary Tract Infection",
            "result" => ["Yes","No"],
            "type" => "details",
          ],
          [
            "data_element_id" => "anc_urine_ketone",
            "name" => "Evidence of Ketone in urine",
            "result" => ["Negative", "+1", "+2", "+3"],
            "type" => "details",
          ],
        ]
      ],
      [
        "data_element_id" => "scr_hiv_test_results",
        "blis_alias" => "Rapid HIV test",
        "name" => "Test Results",
        "result" => ["Reactive", "Non Reactive", "Indeterminate"],
        "additionals" => [
          [
            "data_element_id" => "scr_hiv_test",
            "name" => "HIV Test Undertaken",
            "result" => ["Yes","No"],
            "type" => "requested",
          ],
          [
            "data_element_id" => "scr_hiv_test_results_date",
            "name" => "Date Test Results Received",
            "result" => ["Date"],
            "type" => "date",
          ],
        ]
      ],
      [
        "data_element_id" => "anc_scr_serology_test_results",
        "blis_alias" => "",//what test exactly is required here
        "name" => "Serology Test Results",
        "result" => ["Reactive", "non-reactive"],
        "additionals" => [
          [
            "data_element_id" => "anc_syphilis_test",
            "name" => "Tested for Syphilis",
            "result" => ["Yes","No"],
            "type" => "requested",
          ],
          [
            "data_element_id" => "scr_syphillis_test_results_no",
            "name" => "Syphilis Test Record Number",
            "result" => ["Text"],
            "type" => "number",
          ],
          [
            "data_element_id" => "scr_syphillis_test_results_date",
            "name" => "Date Test Results Received",
            "result" => ["Date"],
            "type" => "date",
          ],
          [
            "data_element_id" => "scr_syphillis_infected",//what test does this belong to not sure
            "name" => "Client Infected",
            "result" => ["Yes","No"],
            "type" => "details",
          ],
        ]
      ],
      [
        "data_element_id" => "anc_diabetes_test_results",
        "blis_alias" => "",//what test exactly is required here
        "name" => "Test Results",
        "result" => ["Not Diabetic", "Type 1", "Type 2", "Type 3"],
        "additional" => [
          [
            "data_element_id" => "anc_diabetes_test",
            "name" => "Tested for Diabetes",
            "result" => ["Yes","No"],
            "type" => "requested",
          ],
          [
            "data_element_id" => "anc_diabetes_test_results_date",
            "name" => "Date of Test Results",
            "result" => ["Date"],
            "type" => "date",
          ],
        ]
      ],
      [
        "data_element_id" => "scr_diabetes_glucose_tolerance_test_results",
        "blis_alias" => "",//what test exactly is required here
        "name" => "Glucose tolerance test results (mg/dL)",
        "result" => ["Integer"],
        "additional" => [
          [
            "data_element_id" => "scr_diabetes_glucose_tolerance_test",
            "name" => "Glucose Tolerance Test",
            "result" => ["Yes","No"],
            "type" => "requested",
          ],
          [
            "data_element_id" => "scr_diabetes_glucose_tolerance_test_results_date",
            "name" => "Date of Test Results",
            "result" => ["Date"],
            "type" => "date",
          ],
        ]
      ],
      [
        "data_element_id" => "scr_tb_gene_xpert_test_results",
        "blis_alias" => "",//what test exactly is required here
        "name" => "Gene Xpert Test Results",
        "result" => ["MTB detected", "rifampicin resistance not detected","MTB detected", "rifampicin resistance detected","MTB detected", "rifampicin resistance indeterminate","MTB not detected","Invalid/ no result / error"],
        "additional" => [
          [
            "data_element_id" => "scr_tb_gene_xpert_test",
            "name" => "Gene Xpert Test Done",
            "result" => ["Yes","No"],
            "type" => "requested",
          ],
          [
            "data_element_id" => "scr_tb_gene_xpert_results_no",
            "name" => "Gene Xpert Test Result Number",
            "result" => ["Text"],
            "type" => "number",
          ],
          [
            "data_element_id" => "scr_tb_gene_xpert_test_results_date",
            "name" => "Date Gene Xpert Test Results Received",
            "result" => ["Date"],
            "type" => "date",
          ],
        ]
      ],
      [
        "data_element_id" => "scr_tb_sputum_test_result",
        "blis_alias" => "",//what test exactly is required here
        "name" => "Sputum Test Resul",
        "result" => ["Positive", "Negative"],
        "additional" => [
          [
            "data_element_id" => "scr_tb_sputum_test",
            "name" => "Sputum Test Done",
            "result" => ["Yes","No"],
            "type" => "requested",
          ],
          [
            "data_element_id" => "scr_tb_sputum_test_result_date",
            "name" => "Date of Sputum Test Result",
            "result" => ["Date"],
            "type" => "date",
          ],
          [
            "data_element_id" => "scr_tb_sputum_test_result_no",
            "name" => "Sputum Test Results No. ",
            "result" => ["Text"],
            "type" => "number",
          ],
          [
            "data_element_id" => "scr_tb_chest_xray",
            "name" => "Chest Xray Required",
            "result" => ["Yes","No"],
            "type" => "details",
          ],
        ]
      ],
      [
        "data_element_id" => "scr_malaria_test_result",
        "blis_alias" => "BS for mps",
        "name" => "Malaria Test Result",
        "result" => ["Negative", "Positive", "Invalid Result"],
        "additional" => [
          [
            "data_element_id" => "anc_malaria_test",
            "name" => "Tested for Malari",
            "result" => ["Yes","No"],
            "type" => "requested",
          ],
          [
            "data_element_id" => "scr_malaria_test_result_date",
            "name" => "Date of Test Result",
            "result" => ["Date"],
            "type" => "date",
          ],
        ]
      ],
      [
        "data_element_id" => "anc_cervical_cancer_test_result",
        "blis_alias" => "",//what test exactly is required here
        "name" => "Cervical Cancer Test Result",
        "result" => ["Text"],
        "additional" => [
          [
            "data_element_id" => "anc_cervical_cancer_test",
            "name" => "Tested for cervical cancer",
            "result" => ["Yes","No"],
            "type" => "requested",
          ],
          [
            "data_element_id" => "anc_cervical_cancer_test_result_date",
            "name" => "Date of test results",
            "result" => ["Date"],
            "type" => "date",
          ],
        ]
      ],
      [
        "data_element_id" => "del_syphillis_test_results",
        "blis_alias" => "",
        "name" => "Syphilis Test Results",
        "result" => ["Reactive", "non-reactive"],
        "additional" => [
          [
            "data_element_id" => "del_syphillis_test",
            "name" => "Tested for Syphilis",
            "result" => ["Yes","No"],
            "type" => "requested",
          ],
          [
            "data_element_id" => "del_syphillis_test_results_no",
            "name" => "Syphilis Test Record Number",
            "result" => ["Text"],
            "type" => "number",
          ],
          [
            "data_element_id" => "del_syphillis_test_results_date",
            "name" => "Date Test Results Received",
            "result" => ["Date"],
            "type" => "date",
          ],
        ]
      ],
      [
        "data_element_id" => "pnc_Hb_test_results",
        "blis_alias" => "HB",
        "name" => "HB Test Results",
        "result" => ["Positive", "Negative", "Not Available"],
        "additional" => [
          [
            "data_element_id" => "pnc_Hb_Test",
            "name" => "HB Test Undertaken",
            "result" => ["Tested onsite", "Blood sent away", "No"],
            "type" => "requested",
          ],
          [
            "data_element_id" => "pnc_Hb_test_results_no",
            "name" => "HB (g/dl)",
            "result" => ["Number"],
            "type" => "number",
          ],
          [
            "data_element_id" => "pnc_hb_test_results_date",
            "name" => "HB Test Results Date",
            "result" => ["Date"],
            "type" => "date",
          ],
          [
            "data_element_id" => "pnc_hb_test_results_no",
            "name" => "HB Test Results No",
            "result" => ["Text"],
            "type" => "details",
          ],
        ]
      ],
      [
        "data_element_id" => "pnc_urine_test_results",
        "blis_alias" => "",
        "name" => "Test Results",
        "result" => ["Text"],
        "additionals" => [
          [
            "data_element_id" => "pnc_urine_test",
            "name" => "Urine Test Undertaken",
            "result" => ["Yes","No"],
            "type" => "requested",
          ],
          [
            "data_element_id" => "pnc_urine_test_details",
            "name" => "Details on what urine was tested for ",
            "result" => ["Text"],
            "type" => "details",
          ],
          [
            "data_element_id" => "pnc_urine_test_results_no",
            "name" => "Test Results Number",
            "result" => ["Text"],
            "type" => "number",
          ],
          [
            "data_element_id" => "pnc_urine_test_results_date",
            "name" => "Urine Test Results Date",
            "result" => ["Date"],
            "type" => "date",
          ],
        ]
      ],
      [
        "data_element_id" => "pnc_hiv_test_results",
        "blis_alias" => "Rapid HIV test",
        "name" => "Test Results",
        "result" => ["Reactive", "Non Reactive", "Indeterminate"],
        "additionals" => [
          [
            "data_element_id" => "pnc_hiv_test",
            "name" => "HIV Test Undertaken",
            "result" => ["Yes","No"],
            "type" => "requested",
          ],
          [
            "data_element_id" => "pnc_hiv_test_results_date",
            "name" => "Date Test Results Received",
            "result" => ["Date"],
            "type" => "date",
          ],
        ]
      ],
      [
        "data_element_id" => "pnc_urine_protein_test",
        "blis_alias" => "",
        "name" => "Protein Test Normal",
        "result" => ["Yes","No"],
      ],
      [
        "data_element_id" => "pnc_urinary_tract_infection",
        "blis_alias" => "",
        "name" => "Evidence of Urinary Tract Infection",
        "result" => ["Yes","No"],
      ],
      [
        "data_element_id" => "tb_sputumsmear_test_results",
        "blis_alias" => "",
        "name" => "Sputum Test Resul",
        "result" => ["Positive", "Negative"],
        "additionals" => [
          [
            "data_element_id" => "tb_sputumsmear_test",
            "name" => "Sputum Test Done",
            "result" => ["Yes","No"],
            "type" => "requested",
          ],
          [
            "data_element_id" => "tb_sputumsmear_test_date",
            "name" => "Date of Sputum Test Result",
            "result" => ["Date"],
            "type" => "date",
          ],
          [
            "data_element_id" => "tb_sputumsmeartest_no",
            "name" => "Sputum Test Results No. ",
            "result" => ["Text"],
            "type" => "number",
          ],
        ]
      ],
      [
        "data_element_id" => "tb_gene_xpert_test_results",
        "blis_alias" => "",
        "name" => "Gene Xpert Test Results",
        "result" => ["MTB detected", "rifampicin resistance not detected","MTB detected", "rifampicin resistance detected","MTB detected", "rifampicin resistance indeterminate","MTB not detected","Invalid/ no result / error"],
        "additionals" => [
          [
            "data_element_id" => "tb_gene_xpert_lab_request",
            "name" => "Gene Xpert Test Requested",
            "result" => ["Yes","No"],
            "type" => "requested",
          ],
          [
            "data_element_id" => "tb_gene-xpert_test_resullt_no",
            "name" => "Gene Xpert Test Result Number",
            "result" => ["Text"],
            "type" => "number",
          ],
          [
            "data_element_id" => "tb_gene_xpert_test_results_date",
            "name" => "Date Gene Xpert Test Results Received",
            "result" => ["Date"],
            "type" => "date",
          ],
        ]
      ],
      [
        "data_element_id" => "tb_chest_xray_results",
        "blis_alias" => "",
        "name" => "Chest X-ray Results",
        "result" => ["Text"],
        "additionals"=>[
          [
            "data_element_id" => "tb_chest_xray",
            "name" => "Chest X-ray Taken",
            "result" => ["Yes","No"],
            "type"=>"requested",
          ],
          [
            "data_element_id" => "tb_chest_xray_date",
            "name" => "Date of Chest X-ray",
            "result" => ["Date"],
            "type"=>"date",
          ],
        ]
      ],
      [
        "data_element_id" => "tb_hiv_test_results",
        "blis_alias" => "Rapid HIV test",
        "name" => "HIV Test Results",
        "result" => ["Reactive","Not Reactive","Indeterminate"],
        "additionals"=>[
          [
            "data_element_id" => "tb_hiv_test",
            "name" => "HIV Test Performed",
            "result" => ["Yes/No/Declined"],
            "type"=>"requested",
          ],
          [
            "data_element_id" => "tb_hiv_test_results_date",
            "name" => "HIV Test Results Date",
            "result" => ["Date"],
            "type"=>"date",
          ],
          [
            "data_element_id" => "tb_hiv_test_results_no",
            "name" => "HIV Test Results Number",
            "result" => ["Text"],
            "type"=>"number",
          ],
        ]
      ],
      [
        "data_element_id" => "tb_sputumsmear_test_results",
        "blis_alias" => "",
        "name" => "Sputum Test Resul",
        "result" => ["Positive", "Negative"],
        "additionals"=>[
          [
            "data_element_id" => "tb_sputumsmear_test",
            "name" => "Sputum Test Done",
            "result" => ["Yes","No"],
            "type" =>"requested",
          ],
          [
            "data_element_id" => "tb_sputumsmear_test_date",
            "name" => "Date of Sputum Test Result",
            "result" => ["Date"],
            "type"=>"date",
          ],
          [
            "data_element_id" => "tb_sputumsmeartest_no",
            "name" => "Sputum Test Results No. ",
            "result" => ["Text"],
            "type"=>"number",
          ],
        ]
      ],
      [
        "data_element_id" => "tb_AFB_test_results",
        "blis_alias" => "",
        "name" => "AFB Test Results",
        "result" => ["Positive", "Negative"],
        "additionals" => [
          [
            "data_element_id" => "tb_AFB_test",
            "name" => "AFB Test done",
            "result" => ["Yes","No"],
            "type" => "requested",
          ],
          [
            "data_element_id" => "tb_AFB_test_results_date",
            "name" => "AFB Test Results Date",
            "result" => ["Date"],
            "type" => "date",
          ],
          [
            "data_element_id" => "tb_AFB_test_results_no",
            "name" => "AFB Test Results No",
            "result" => ["Text"],
            "type" => "number",
          ],
        ]
      ],
      [
        "data_element_id" => "tb_gene_xpert_test_results",
        "blis_alias" => "",
        "name" => "Gene Xpert Test Results",
        "result" => ["MTB detected", "rifampicin resistance not detected","MTB detected", "rifampicin resistance detected","MTB detected", "rifampicin resistance indeterminate","MTB not detected","Invalid/ no result / error"],
        "additionals" => [
          [
            "data_element_id" => "tb_gene_xpert_lab_request",
            "name" => "Gene Xpert Test Requested",
            "result" => ["Yes","No"],
            "type" => "requested",
          ],
          [
            "data_element_id" => "tb_gene-xpert_test_resullt_no",
            "name" => "Gene Xpert Test Result Number",
            "result" => ["Text"],
            "type" => "number",
          ],
          [
            "data_element_id" => "tb_gene_xpert_test_results_date",
            "name" => "Date Gene Xpert Test Results Received",
            "result" => ["Date"],
            "type" => "date",
          ],
        ]
      ],
      [
        "data_element_id" => "tb_culture_growth",
        "blis_alias" => "",
        "name" => "Growth",
        "result" => ["Growth","No Growth"],
        "additionals" => [
          [
            "data_element_id" => "tb_culture",
            "name" => "Culture Taken",
            "result" => ["Yes","No"],
            "type" => "requested",
          ],
          [
            "data_element_id" => "tb_culture_line",
            "name" => "Culture for Line 1 or Line 2",
            "result" => ["Line 1","Line 2"],
            "type" => "details",
          ],
          [
            "data_element_id" => "tb_culture_date",
            "name" => "Date of culture test",
            "result" => ["Date"],
            "type" => "date",
          ],
          [
            "data_element_id" => "tb_culture_results_date",
            "name" => "Date Test Result Received",
            "result" => ["Date"],
            "type" => "date",
          ],
          [
            "data_element_id" => "tb_culture_test_no",
                "type" => "number",
            "name" => "Culture Test Number",
            "result" => ["Text"],
          ],
          [
            "data_element_id" => "tb_culture_steptomycin",
            "name" => "Culture/sensitivity results - Steptomycin (S)",
            "result" => ["Done", "no result","Sensitive","Reactive"],
            "type" => "details",
          ],
          [
            "data_element_id" => "tb_culture_rifampicin",
            "name" => "Culture/sensitivity results - Rifampicin ®",
            "result" => ["Done", "no result","Sensitive","Reactive"],
            "type" => "details",
          ],
          [
            "data_element_id" => "tb_culture_isoniazid",
            "name" => "Culture/sensitivity results - Isoniazid (H)",
            "result" => ["Done", "no result","Sensitive","Reactive"],
            "type" => "details",
          ],
          [
            "data_element_id" => "tb_culture_ethambutol",
            "name" => "Culture/sensitivity results - Ethambutol (E)",
            "result" => ["Done", "no result","Sensitive","Reactive"],
            "type" => "details",
          ],
          [
            "data_element_id" => "tb_culture_kanamycin",
            "name" => "Culture/sensitivity results - Kanamycin",
            "result" => ["Done", "no result","Sensitive","Reactive"],
            "type" => "details",
          ],
          [
            "data_element_id" => "tb_culture_lerogloxacin",
            "name" => "Culture/sensitivity results - Lerogloxacin (Quinalone)",
            "result" => ["Done", "no result","Sensitive","Reactive"],
            "type" => "details",
          ],
        ]
      ],
      [
        "data_element_id" => "tb_lpa_results",
        "blis_alias" => "",
        "name" => "LPA Results",
        "result" => ["Positive", "Negative"],
        "additionals" => [
          [
            "data_element_id" => "tb_lpa",
            "name" => "Line Probe Assay (LPA) Test",
            "result" => ["Yes","No"],
            "type" => "requested",
          ],
          [
            "data_element_id" => "tb_lpa_line",
            "name" => "LPA for Line 1 or Line 2",
            "result" => ["Line 1","Line 2"],
            "type" => "details",
          ],
          [
            "data_element_id" => "lpa_results_line1",
            "name" => "LPA Results Line 1",
            "result" => ["Rfampicin","Isoniazid"],
            "type" => "details",
          ],
          [
            "data_element_id" => "lpa_results_line2",
            "name" => "LPA Results Line 2",
            "result" => ["Lerogloxacin (Quinalone)"," Kanamycin "],
            "type" => "details",
          ],
          [
            "data_element_id" => "lpa_sensitivity_rifampicin",
            "name" => "LPA Sensitivity Rifampicin",
            "result" => ["Not Sensitive","Sensitive"," Resistant "],
            "type" => "details",
          ],
          [
            "data_element_id" => "lpa_sensitivity_isonazid",
            "name" => "LPA Sensitivity Isonazid",
            "result" => ["Lerogloxacin (Quinalone)","Kanamycin"],
            "type" => "details",
          ],
          [
            "data_element_id" => "tb_lpa_date",
            "name" => "Date of LPA test",
            "result" => ["Date"],
            "type" => "date",
          ],
          [
            "data_element_id" => "tb_lpa_results_date",
            "name" => "LPA Test Results Received",
            "result" => ["Date"],
            "type" => "date",
          ],
          [
            "data_element_id" => "tb_lpa_test_no",
            "name" => "LPA Test Number",
            "type" => "number",
            "result" => ["Text"],
          ],
        ]
      ],
      [
        "data_element_id" => "preart_hiv_kit1_results",
        "blis_alias" => "Rapid HIV test",
        "name" => "HIV Kit 1 (Kenya) Dhirmine Results",
        "result" => ["Reactive","Not Reactive"],
        "additionals" => [
          [
            "data_element_id" => "preart_hiv_test",
            "name" => "HIV Test Performed",
            "result" => ["Yes","No"],
            "type" => "requested",
          ],
          [
            "data_element_id" => "preart_hiv_date_results",
            "name" => "HIV Test Results Date",
            "result" => ["Date"],
            "type" => "date",
          ],
          [
            "data_element_id" => "preart_hiv_results_no",
            "name" => "HIV Test Results Number",
            "result" => ["Text"],
            "type" => "number",
          ],
        ]
      ],
      [
        "data_element_id" => "preart_hiv_kit2_results",
        "blis_alias" => "Rapid HIV test",
        "name" => "HIV Kit 2 (Kenya) First Response Results",
        "result" => ["Reactive","Not Reactive"],
      ],
      [
        "data_element_id" => "preart_hiv_test_results",
        "blis_alias" => "Rapid HIV test",
        "name" => "HIV Test Results",
        "result" => ["Reactive","Not Reactive","Indeterminate"],
      ],
      [
        "data_element_id" => "preart_CD4",
        "blis_alias" => "",
        "name" => "CD4",
        "result" => ["Number"],
      ],
      [
        "data_element_id" => "pre-art_tb_test_results",
        "blis_alias" => "",
        "name" => "TB Screening Results",
        "result" => ["No TB","Presumed TB","Active TB"],
        "additionals" => [
          [
            "data_element_id" => "preart_tb_test",
            "name" => "Screened for TB",
            "result" => ["Yes","No"],
            "type" => "requested",
          ],
        ]
      ],
      [
        "data_element_id" => "preart_tb_type",
        "blis_alias" => "",
        "name" => "Tuberculosis Type",
        "result" => ["Pulmonary Negative","  Pulmonary Positive"," Extrapulmonary","  Multidrug resistant","  Extensive drug resistant","  Total drug resistant"],
        "additionals" => [
          [
            "data_element_id" => "preart_tb_test_results_date",
            "name" => "TB Results Date",
            "result" => ["Date"],
            "type" => "date",
          ],
          [
            "data_element_id" => "preart_tb_test_results_no",
            "name" => "TB Test Results Number",
            "result" => ["Text"],
            "type" => "number",
          ],
        ]
      ],
      [
        "data_element_id" => "art_CD4_results",
        "blis_alias" => "",
        "name" => "CD4 Results",
        "result" => ["Number"],
        "additionals" => [
          [
            "data_element_id" => "art_CD4_lab",
            "name" => "CD4 Lab Request",
            "result" => ["Yes","No"],
            "type" => "requested",
          ],
          [
            "data_element_id" => "art_CD4_test_no",
            "name" => "CD4 Test No",
            "result" => ["Text"],
            "type" => "number",
          ],
          [
            "data_element_id" => "art_CD4_test_results_date",
            "name" => "CD4 Test Results Date",
            "result" => ["Date"],
            "type" => "date",
          ],
        ]
      ],
      [
        "data_element_id" => "art_viral_load_lab",
        "blis_alias" => "",
        "name" => "Viral Load Lab Request",
        "result" => ["Yes","No"],
      ],
      [
        "data_element_id" => "art_viral_load_test_results",
        "blis_alias" => "",
        "name" => "Viral Load Test Results",
        "result" => ["Number"],
        "additionals" => [
          [
            "data_element_id" => "art_viral_load_lab",
            "name" => "Viral Load Lab Request",
            "result" => ["Yes","No"],
            "type" => "requested",
          ],
          [
            "data_element_id" => "art_viral_load_test_no",
            "name" => "Viral Load Test No",
            "result" => ["Text"],
            "type" => "number",
          ],
          [
            "data_element_id" => "art_viral_load_test_results_date",
            "name" => "Viral Load Test Results Date",
            "result" => ["Date"],
            "type" => "date",
          ],
          [
            "data_element_id" => "art_viral_load_suppressed",
            "name" => "Viral Load Suppressed <1000 copies/mL",
            "result" => ["Yes","No"],
            "type" => "details",
          ],
        ],
      ],
      [
        "data_element_id" => "art_Hb",
        "blis_alias" => "HB",
        "name" => "HB (g/dl)",
        "result" => ["Number"],
        "additionals" => [ 
            [
            "data_element_id" => "art_hb_test",
            "name" => "HB Test Undertaken",
            "result" => ["Tested onsite","Blood sent away","No"],
            "type" => "details",
            ],
            [
            "data_element_id" => "art_hb_test_results_date",
            "name" => "HB Test Results Date",
            "result" => ["Date"],
            "type" => "date",
          ],
          [
            "data_element_id" => "art_hb_test_results_no",
            "name" => "HB Test Results No",
            "result" => ["Text"],
            "type" => "number",
          ],
        ],
      ],
      [
        "data_element_id" => "art_sputum_results",
        "blis_alias" => "",//what test exactly is required here
        "name" => "Sputum Test Resul",
        "result" => ["Positive", "Negative"],
        "additionals" => [ 
          [
            "data_element_id" => "art_sputum_test",
            "name" => "Sputum Test Done",
            "result" => ["Yes","No"],
            "type" => "requested",
          ],
        ],
      ],
      [
        "data_element_id" => "art_gene_xpert_results",
        "blis_alias" => "",//what test exactly is required here
        "name" => "Gene Xpert Test Results",
        "result" => ["MTB detected", "rifampicin resistance not detected","MTB detected", "rifampicin resistance detected","MTB detected", "rifampicin resistance indeterminate","MTB not detected","Invalid/ no result / error"],
        "additionals" => [ 
          [
            "data_element_id" => "art_gene_xpert_lab_request",
            "name" => "Gene Xpert Test Done",
            "result" => ["Yes","No"],
            "type" => "requested",
          ],
          [
            "data_element_id" => "art_gene-xpert_test_resullt_no",
            "name" => "Gene Xpert Test Result No",
            "result" => ["Text"],
            "type" => "number",
          ],
          [
            "data_element_id" => "art_gene_xpert_test_results_date",
            "name" => "Gene Xpert Test Results Date",
            "result" => ["Date"],
            "type" => "date",
          ],
        ],
      ],
      [
        "data_element_id" => "art_liver_test_results",
        "blis_alias" => "LFTS",
        "name" => "Liver Function Test Results",
        "result" => ["Normal","Low","High"],
        "additionals" => [
          [
            "data_element_id" => "art_liver_test",
            "name" => "Liver Function Test Requested",
            "result" => ["Yes","No"],
            "type" => "requested",
          ],
          [
            "data_element_id" => "art_liver_test_results_details",
            "name" => "Liver Function Test Restuls Details",
            "result" => ["Text"],
            "type" => "details",
          ],
          [
            "data_element_id" => "art_liver_test_results_no",
            "name" => "Liver Function Test Results No",
            "result" => ["Text"],
            "type" => "number",
          ],
          [
            "data_element_id" => "art_liver_test_results_date",
            "name" => "Date Liver Function Test Results Received",
            "result" => ["Date"],
            "type" => "date",
          ],
        ],
      ],
      [
        "data_element_id" => "art_renal_test_results",
        "blis_alias" => "RFTS",
        "name" => "Renal Function Test Results",
        "result" => ["Normal","Low"],
        "additionals" => [
          [
            "data_element_id" => "art_renal_test",
            "name" => "Renal Function Test Requested",
            "result" => ["Yes","No"],
            "type" => "requested",
          ],
          [
            "data_element_id" => "art_renal_test_results_details",
            "name" => "Renal Function Test Restuls Details",
            "result" => ["Text"],
            "type" => "details",
          ],
          [
            "data_element_id" => "art_renal_test_results_no",
            "name" => "Renal Function Test Results No",
            "result" => ["Text"],
            "type" => "number",
          ],
          [
            "data_element_id" => "art_renal_test_results_date",
            "name" => "Date Renal Function Test Results Received",
            "result" => ["Date"],
            "type" => "date",
          ],
        ]
      ],
      [
        "data_element_id" => "art_preg_test_results",
        "blis_alias" => "Pregnancy test",
        "name" => "Pregnancy Test Results",
        "result" => ["Positive","Negative","Inconclusive"],
        "additionals" => [ 
          [
            "data_element_id" => "art_preg_test",
            "name" => "Pregnancy Test Requested",
            "result" => ["Not appropriate","Yes","No"],
            "type" => "requested",
          ],
          [
            "data_element_id" => "art_preg_test_results_details",
            "name" => "Pregnancy Test Results Details",
            "result" => ["Text"],
            "type" => "details",
          ],
          [
            "data_element_id" => "art_preg_test_results_no",
            "name" => "Pregnancy Test Results No",
            "result" => ["Text"],
            "type" => "number",
          ],
          [
            "data_element_id" => "art_preg_test_results_date",
            "name" => "Date Pregnancy Test Results Received",
            "result" => ["Date"],
            "type" => "date",
          ],
        ],
      ],
      [
        "data_element_id" => "cc_VIA_results",
        "blis_alias" => "",//what test exactly is required here
        "name" => "VIA / VILI Results",
        "result" => ["VIA Negative","VIA Positive","VILI Negative","VILI Positive","Suspicious for Cancer"],
        "additionals" => [ 
          [
            "data_element_id" => "cc_VIA",
            "name" => "VIA/VILI Screening Undertaken",
            "result" => ["Yes","No"],
            "type" => "details",
          ],
        ],
      ],
      [
        "data_element_id" => "cc_PapSmear_results",
        "blis_alias" => "",//what test exactly is required here
        "name" => "Pap Smear Results",
        "result" => ["Normal","Pre-Invasive Cancer","Invasive Cancer"],
        "additionals" => [
            [
              "data_element_id" => "cc_PapSmear",
              "name" => "Pap Smear Undertaken",
              "result" => ["Yes","No"],
              "type" => "requested",
            ],
            [
              "data_element_id" => "cc_PapSmear_results_date",
              "name" => "Date of test results",
              "result" => ["Date"],
              "type" => "date",
            ],
            [
              "data_element_id" => "cc_PapSmear_results_no",
              "name" => "Test Number",
              "result" => ["Text"],
              "type" => "number",
            ],
        ],
      ],
      [
        "data_element_id" => "cc_HPV_results",
        "blis_alias" => "",//what test exactly is required here
        "name" => "HPV Test Results",
        "result" => ["Negative","Positive"],
        "additionals" => [
          [
            "data_element_id" => "cc_HPV",
            "name" => "HPV Test Undertaken",
            "result" => ["Yes","no"],
            "type" => "details",
          ],
          [
            "data_element_id" => "cc_HPV_results_date",
            "name" => "Date of test result",
            "result" => ["Date"],
            "type" => "date",
          ],
          [
            "data_element_id" => "cc_HPV_results_no",
            "name" => "HPV Test Number",
            "result" => ["Text"],
            "type" => "number",
          ],
        ],
      ],
      [
        "data_element_id" => "cc_colposcopy_results",
        "blis_alias" => "",//what test exactly is required here
        "name" => "Colposcopy Results",
        "result" => ["Satisfactory","Unsatisfactory","Normal","Acetowhite","eukoplakia","Punctation","Abnormal"],
        "additionals" => [
          [
            "data_element_id" => "cc_cervicography",
            "name" => "Cervicography undertaken",
            "result" => ["Yes","No"],
            "type" => "details",
          ],
        ]
      ],
      [
        "data_element_id" => "fp_hiv_test_results_repeatable",
        "blis_alias" => "Rapid HIV test",
        "name" => "Test Results",
        "result" => ["Reactive", "Non Reactive", "Indeterminate"],
        "additionals" => [
          [
            "data_element_id" => "fp_hiv_test_repeatable",
            "name" => "HIV Test Undertaken",
            "result" => ["Yes","No"],
            "type" => "details",
          ],
          [
            "data_element_id" => "fp_hiv_test_results_date",
            "name" => "Date Test Results Received",
            "result" => ["Date"],
            "type" => "date",
          ],
        ],
      ],
      [
        "data_element_id" => "fp_cervical_cancer_result_repeatable",
        "blis_alias" => "",//what test exactly is required here
        "name" => "Cervical Cancer Test Result",
        "result" => ["Positive"," Negative"," Suspected","Pap Smear Normal"," Low-grade squamous intraepithelial lesions (LSIL)"," High-grade squamous intraepithelial lesions (HSIL)","Overt cancer"],
        "additionals" => [
          [
            "data_element_id" => "fp_cervical_cancer_screening_repeatable",
            "name" => "Tested for cervical cancer",
            "result" => ["Yes","No"],
            "type" => "requested",
          ],
          [
            "data_element_id" => "fp_cervical_cancer_screening_method",
            "name" => "Cervical Cancer Screening Method",
            "result" => ["Visual Inspection with Acetic Acid (VIA)"," Visual Inspection with Lugols Iodine (VILI)","  Pap Smear"," Human papillomavirus (HPV) Test"],
            "type" => "details",
          ],
        ],
      ],
      [
        "data_element_id" => "opd_hiv_test_results",
        "blis_alias" => "Rapid HIV test",
        "name" => "HIV Test Results",
        "result" => ["Reactive","Not Reactive","Indeterminate"],
        "additionals" => [
          [
            "data_element_id" => "opd_hiv_test",
            "name" => "HIV Test Performed",
            "result" => ["Yes","No"],
            "type" => "requested",
          ],
          [
            "data_element_id" => "opd_hiv_results_date",
            "name" => "HIV Test Results Date",
            "result" => ["Date"],
            "type" => "date",
          ],
          [
            "data_element_id" => "opd_hiv_results_no",
            "name" => "HIV Test Results Number",
            "result" => ["Text"],
            "type" => "number",
          ],
        ],
      ],
      [
        "data_element_id" => "opd_tb_test_results",
        "blis_alias" => "",//what test exactly is required here, which tb test
        "name" => "TB Screening Results",
        "result" => ["Positive","Negative"],
        "additionals" => [
          [
            "data_element_id" => "opd_tb_screening",
            "name" => "Screened for TB",
            "result" => ["Yes","No"],
             "type" => "details",
          ],
          [
            "data_element_id" => "opd_tb_test_results_date",
            "name" => "TB Test Results Date",
            "result" => ["Date"],
            "type" => "date",
          ],
          [
            "data_element_id" => "opd_tb_test_results_no",
            "name" => "TB Test Results No",
            "result" => ["Text"],
            "type" => "number",
          ],
       ],
      ],
      [
        "data_element_id" => "popc_hiv_test_results",
        "blis_alias" => "Rapid HIV test",
        "name" => "HIV Test Results",
        "result" => ["Reactive", "Non Reactive", "Indeterminate"],
        "additionals" => [
            [
              "data_element_id" => "popc_hiv_test",
              "name" => "Was a HIV Test performed",
              "result" => ["Yes","No","Declined"],
              "type" => "requested",
            ],
            [
              "data_element_id" => "popc_hiv_results_date",
              "name" => "Date Test Results Received",
              "result" => ["Date"],
              "type" => "date",
            ],
            [
              "data_element_id" => "popc_hiv_results_no",
              "name" => "HIV Test Results Number",
              "result" => ["Text"],
              "type" => "number",
            ],
           ],
      ],
      [
        "data_element_id" => "popc_electrophoresis_test_results",
        "blis_alias" => "",//what test exactly is required here
        "name" => "Electrophoresis Test Results",
        "result" => ["Positive", "Negative", "Not Available"],
        "additionals" => [
           [
            "data_element_id" => "popc_electrophoresis_test",
            "name" => "Electrophoresis Test Undertaken",
            "result" => ["Tested onsite", "Blood sent away", "No"],
             "type" => "requested",
          ],
          [
            "data_element_id" => "popc_electrophoresis_test_results_date",
            "name" => "Electrophoresis Test Results Date",
            "result" => ["Date"],
             "type" => "date",
          ],
          [
            "data_element_id" => "popc_electrophoresis_test_results_no",
            "name" => "Electrophoresis Test Results Number",
            "result" => ["Text"],
             "type" => "number",
          ],
        ],
      ],
      [
        "data_element_id" => "popc_hb",
        "blis_alias" => "HB",
        "name" => "HB (g/dl)",
        "result" => ["Number"],
      ],
      [
        "data_element_id" => "popc_haemogram_test_results",
        "blis_alias" => "",//what test exactly is required here, is this CBC
        "name" => "Haemogram Test Results",
        "result" => ["Normal/ Abnormal"],
        "additionals" => [
          [
            "data_element_id" => "popc_haemogram_test",
            "name" => "Full Haemogram Undertaken",
            "result" => ["Yes","No"],
            "type" => "requested",
          ],
          [
            "data_element_id" => "popc_haemogram_test_result_details",
            "name" => "Haemogram Test Result Details",
            "result" => ["Text"],
            "type" => "details",
          ],
          [
            "data_element_id" => "popc_haemogram_test_results_date",
            "name" => "Haemogram Test Results Date",
            "result" => ["Date"],
            "type" => "date",
          ],
          [
            "data_element_id" => "popc_haemogram_test_results_no",
            "name" => "Haemogram Test Results Number",
            "result" => ["Text"],
            "type" => "number",
          ],
        ],
      ],
      [
        "data_element_id" => "popc_sickling_test_results",
        "blis_alias" => "Sickling Test",
        "name" => "Sickling Test Results",
        "result" => ["Positive", "Negative"],
        "additionals" => [
          [
            "data_element_id" => "popc_sickling_test",
            "name" => "Sickling Test Undertaken",
            "result" => ["Yes","No"],
            "type" => "details",
          ],
          [
            "data_element_id" => "popc_sickling_test_results_date",
            "name" => "Sickling Test Results Date",
            "result" => ["Date"],
            "type" => "date",
          ],
          [
            "data_element_id" => "popc_sickling_test_results_no",
            "name" => "Sickling Test Results Number",
            "result" => ["Text"],
            "type" => "number",
          ],
        ],
      ],
    ];


    \Eloquent::unguard();
    foreach ($testTypes as $testType) {

      if ($testType['blis_alias'] != '') {

        $testTypeId = DB::connection('mysqlml4afrika')->table('test_types')->insertGetId([
          'data_element_id' => $testType['data_element_id'],
          'blis_alias' => $testType['blis_alias'],
          'name' => $testType['name'],
        ]);
        echo $testType['data_element_id']."\n";

        foreach ($testType['result'] as $result) {
          DB::connection('mysqlml4afrika')->table('results')->insert([
            'test_type_id' => $testTypeId,
            'result' => $result,
          ]);
        }

        // if additionals is in data_element
        if (array_key_exists('additionals', $testType)) {
          // emr_additional_infos
          foreach ($testType['additionals'] as $additional) {
            $additionalId = DB::connection('mysqlml4afrika')->table('additionals')->insert([
              'test_type_id' => $testTypeId,
              'type' => $additional['type'],
            ]);
            foreach ($additional['result'] as $result) {
              DB::connection('mysqlml4afrika')->table('additional_results')->insert([
                'additional_id' => $additionalId,
                'result' => $result,
              ]);
            }
          }
        }
      }
    }
  }
}
