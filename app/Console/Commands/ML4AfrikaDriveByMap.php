<?php
namespace App\Console\Commands;
use DB;
use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;
/*
 *use passport not jwt else get the error
 *The resource owner or authorization server denied the request.
 *{"exception":"[object] ( League\\OAuth2\\Server\\Exception\\OAuthServerException
 */

class ML4AfrikaDriveByMap extends Command
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
              |   destroy   |
              php artisan ml4afrika:drivebymap
             \**            **/         
  protected $signature = 'ml4afrika:drivebymap';
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
        "result" => [
          // "data_element_id" => "preg_test_results",
          "data_element_id" => "preg_test_results",
          "emr_test_type_name" => "Pregnancy Test Results",
          "emr_measure_range_aliases" => ["Positive","Negative","Inconclusive"],
          "info_type" => "result",
        ],
        "requested" => [
          // "data_element_id" => "preg_test",
          // "data_element_id" => "preg_test_BLIS",
          "data_element_id" => "hXEpm4vjgmq",
          "emr_test_type_name" => "Pregnancy Test Requested",
          "test_type_name" => "Pregnancy Test",
          "info_type" => "requested",
        ],
        "details" => [
          "data_element_id" => "preg_test_results_details",
          "emr_test_type_name" => "Pregnancy Test Results Details",
          "info_type" => "details",
        ],
        "identifier" => [
          "data_element_id" => "preg_test_results_no",
          "emr_test_type_name" => "Pregnancy Test Results No",
          "info_type" => "identifier",
        ],
        "date" => [
          "data_element_id" => "preg_test_results_date",
          "emr_test_type_name" => "Date Pregnancy Test Results Received",
          "info_type" => "date",
        ],
      ],
      [
        "result" => [
          "data_element_id" => "anc_hb_test_results",
          "emr_test_type_name" => "HB Test Results",
          "emr_measure_range_aliases" => ["Positive", "Negative", "Not Available"],
          "info_type" => "result",
        ],
        "requested" => [
          "data_element_id" => "anc_hb_test",
          "test_type_name" => "HB",
          "emr_test_type_name" => "HB Test Undertaken",
          "info_type" => "requested",
        ],
        "date" => [
          "data_element_id" => "anc_hb_test_results_date",
          "emr_test_type_name" => "HB Test Results Date",
          "info_type" => "date",
        ],
        "identifier" => [
          "data_element_id" => "anc_hb_test_results_no",
          "emr_test_type_name" => "HB Test Results No",
          "info_type" => "identifier",
        ],
      ],
      [
        "result" => [
          "data_element_id" => "scr_hb_test_results_gdl",
          "emr_test_type_name" => "HB (g/dl)",
          "emr_measure_range_aliases" => null,
          "info_type" => "result",
        ],
        "requested" => [
          "data_element_id" => "scr_hb_test_results_gdl",
          "test_type_name" => "HB",
          "emr_test_type_name" => "HB (g/dl)",
          "info_type" => "requested",
        ],
      ],
      [
        "result" => [
          "data_element_id" => "anc_rh_test_results",
          "emr_test_type_name" => "RH Test Results",
          "emr_measure_range_aliases" => ["Rh Positive / Rh Negative"],
          "info_type" => "result",
        ],
        "requested" => [
          "data_element_id" => "anc_rh_test",
          "emr_test_type_name" => "Rapid Rhesus Blood Group Test Undertaken",
          "test_type_name" => "",
          "info_type" => "requested",
        ],
        "details" => [
          "data_element_id" => "anc_rh_test_results_details",
          "emr_test_type_name" => "Rhesus Factor Test Results Details",
          "info_type" => "details",
        ],
        "identifier" => [
          "data_element_id" => "anc_rh_test_results_no",
          "emr_test_type_name" => "Rhesus Test Record Number",
          "info_type" => "identifier",
        ],
        "date" => [
          "data_element_id" => "scr_rhesus_test_results_date",
          "emr_test_type_name" => "Rhesus Test Results Date",
          "info_type" => "date",
        ],
      ],
      [
        "result" => [
          "data_element_id" => "scr_urine_test_results",
          "emr_test_type_name" => "Test Results",
            //what test exactly is required here
          "emr_measure_range_aliases" => null,
          "info_type" => "result",
        ],
        "requested" => [
          "data_element_id" => "scr_urine_test",
          "emr_test_type_name" => "Urine Test Undertaken",
          "test_type_name" => "",
          "info_type" => "requested",
        ],
        "details" => [
          "data_element_id" => "scr_urine_test_details",
          "emr_test_type_name" => "Details on what urine was tested for ",
          "info_type" => "details",
        ],
        "identifier" => [
          "data_element_id" => "scr_urine_test_results_no",
          "emr_test_type_name" => "Test Results Number",
          "info_type" => "identifier",
        ],
        "date" => [
          "data_element_id" => "scr_urine_test_results_date",
          "emr_test_type_name" => "Urine Test Results Date",
          "info_type" => "date",
        ],
      ],
      [
        "result" => [
          "data_element_id" => "scr_urine_protein_test_results",
          "emr_test_type_name" => "Protein Test Results",
          "emr_measure_range_aliases" => ["+1 (urinary tract infection)", "+2 (pre-eclampsia)", "+3 (eclampsia)", "+4"],
          "info_type" => "result",
        ],
        "requested" => [
          "data_element_id" => "scr_urine_protein_test",
          "emr_test_type_name" => "Protein Test Normal",
          "test_type_name" => "",
          "info_type" => "requested",
        ],
        "date" => [
          "data_element_id" => "scr_urine_protein_test_results_date",
          "emr_test_type_name" => "Protein Test Results Received",
          "info_type" => "date",
        ],
        "details" => [
          "data_element_id" => "scr_urine_treatment",
          "emr_test_type_name" => "Treatment",
          "info_type" => "details",
        ],
      ],
      [
        "            " => [
          "data_element_id" => "scr_urine_sugar_test",
          "emr_test_type_name" => "Urine Sugar Test Normal",
          "emr_measure_range_aliases" => null,
          "info_type" => "result",
            // todo: results is a number this complicates things
            /*
          "emr_measure_range_aliases" => ["Yes","No"],
            */
        ],
        "requested" => [
          "data_element_id" => "scr_urine_sugar_test",
          "test_type_name" => "",
          "emr_test_type_name" => "Urine Sugar Test Normal",
          "info_type" => "requested",
        ],
      ],
      [
        "result" => [
          "data_element_id" => "scr_urine_puss_cell_test_results",
          "emr_test_type_name" => "Puss Cell Test Results",
          "emr_measure_range_aliases" => null,
          "info_type" => "result",
        ],
        "requested" => [
          "data_element_id" => "scr_urine_puss_cell_test",
          "test_type_name" => "",
          "emr_test_type_name" => "Tested for Puss Cell",
          "info_type" => "requested",
        ],
        "date" => [
          "data_element_id" => "scr_urine_puss_cell_test_results_date",
          "emr_test_type_name" => "Puss Cell Test Results Received",
          "info_type" => "date",
        ],
      ],
      [
        "result" => [
          "data_element_id" => "scr_epithelialcell_test_results",
          "emr_test_type_name" => "Epithelial Cell Test Results",
          "emr_measure_range_aliases" => null,
          "info_type" => "result",
        ],
        "requested" => [
          "test_type_name" => "",
          "data_element_id" => "scr_epithelialcell_test",
          "emr_test_type_name" => "Tested for Epithelial Cells",
          "info_type" => "requested",
        ],
        "date" => [
          "data_element_id" => "scr_epithelialcell_test_results_date",
          "emr_test_type_name" => "Epithelial  Cell Test Results Received",
          "info_type" => "date",
        ],
      ],
      [
        "result" => [
          "data_element_id" => "anc_urine_infection_test_results",
          "emr_test_type_name" => "Urine Bacterial Infection Test Results",
          "emr_measure_range_aliases" => null,
          "info_type" => "result",
        ],
        "requested" => [
          "test_type_name" => "",
          "data_element_id" => "anc_urine_infection_test",
          "emr_test_type_name" => "Tested for Baterial Infection",
          "info_type" => "requested",
        ],
        "date" => [
          "data_element_id" => "anc_urine_infection_test_results_date",
          "emr_test_type_name" => "Urine Bacterial Infection Test Results Received",
          "info_type" => "date",
        ],
        "details" => [
          "data_element_id" => "anc_urine_tract_infection",
          "emr_test_type_name" => "Evidence of Urinary Tract Infection",
          "info_type" => "details",
        ],
        "details" => [
          "data_element_id" => "anc_urine_ketone",
          "emr_test_type_name" => "Evidence of Ketone in urine",
          "emr_measure_range_aliases" => ["Negative", "+1", "+2", "+3"],
          "info_type" => "result",
          "info_type" => "details",
        ],
      ],
      [
        "result" => [
          "data_element_id" => "scr_hiv_test_results",
          "emr_test_type_name" => "Test Results",
          "emr_measure_range_aliases" => ["Reactive", "Non Reactive", "Indeterminate"],
          "info_type" => "result",
        ],
        "requested" => [
          "data_element_id" => "scr_hiv_test",
          "test_type_name" => "Rapid HIV test",
          "emr_test_type_name" => "HIV Test Undertaken",
          "info_type" => "requested",
        ],
        "date" => [
          "data_element_id" => "scr_hiv_test_results_date",
          "emr_test_type_name" => "Date Test Results Received",
          "info_type" => "date",
        ],
      ],
      [
        "result" => [
          "data_element_id" => "anc_scr_serology_test_results",
          "emr_test_type_name" => "Serology Test Results",
          "emr_measure_range_aliases" => ["Reactive", "non-reactive"],
          "info_type" => "result",
        ],
        "requested" => [
          "data_element_id" => "anc_syphilis_test",
          "test_type_name" => "",
          "emr_test_type_name" => "Tested for Syphilis",
          "info_type" => "requested",
        ],
        "identifier" => [
          "data_element_id" => "scr_syphillis_test_results_no",
          "emr_test_type_name" => "Syphilis Test Record Number",
          "info_type" => "identifier",
        ],
        "date" => [
          "data_element_id" => "scr_syphillis_test_results_date",
          "emr_test_type_name" => "Date Test Results Received",
          "info_type" => "date",
        ],
        "details" => [
          "data_element_id" => "scr_syphillis_infected",//what test does this belong to not sure
          "emr_test_type_name" => "Client Infected",
          "info_type" => "details",
        ],
      ],
      [
        "result" => [
          "data_element_id" => "anc_diabetes_test_results",
          "emr_test_type_name" => "Test Results",
          "emr_measure_range_aliases" => ["Not Diabetic", "Type 1", "Type 2", "Type 3"],
          "info_type" => "result",
        ],
        "requested" => [
          "test_type_name" => "",
          "data_element_id" => "anc_diabetes_test",
          "emr_test_type_name" => "Tested for Diabetes",
          "info_type" => "requested",
        ],
        "date" => [
          "data_element_id" => "anc_diabetes_test_results_date",
          "emr_test_type_name" => "Date of Test Results",
          "info_type" => "date",
        ],
      ],
      [
        "result" => [
          "data_element_id" => "scr_diabetes_glucose_tolerance_test_results",
          "emr_test_type_name" => "Glucose tolerance test results (mg/dL)",
          "emr_measure_range_aliases" => ["Integer"],
          "info_type" => "result",
        ],
        "requested" => [
          "test_type_name" => "",
          "data_element_id" => "scr_diabetes_glucose_tolerance_test",
          "emr_test_type_name" => "Glucose Tolerance Test",
          "info_type" => "requested",
        ],
        "date" => [
          "data_element_id" => "scr_diabetes_glucose_tolerance_test_results_date",
          "emr_test_type_name" => "Date of Test Results",
          "info_type" => "date",
        ],
      ],
      [
        "result" => [
          "data_element_id" => "scr_tb_gene_xpert_test_results",
          "emr_test_type_name" => "Gene Xpert Test Results",
          "emr_measure_range_aliases" => ["MTB detected", "rifampicin resistance not detected","MTB detected", "rifampicin resistance detected","MTB detected", "rifampicin resistance indeterminate","MTB not detected","Invalid/ no result / error"],
          "info_type" => "result",
        ],
        "requested" => [
          "test_type_name" => "",
          "data_element_id" => "scr_tb_gene_xpert_test",
          "emr_test_type_name" => "Gene Xpert Test Done",
          "info_type" => "requested",
        ],
        "identifier" => [
          "data_element_id" => "scr_tb_gene_xpert_results_no",
          "emr_test_type_name" => "Gene Xpert Test Result Number",
          "info_type" => "identifier",
        ],
        "date" => [
          "data_element_id" => "scr_tb_gene_xpert_test_results_date",
          "emr_test_type_name" => "Date Gene Xpert Test Results Received",
          "info_type" => "date",
        ],
      ],
      [
        "result" => [
          "data_element_id" => "scr_tb_sputum_test_result",
          "emr_test_type_name" => "Sputum Test Resul",
          "emr_measure_range_aliases" => ["Positive", "Negative"],
          "info_type" => "result",
        ],
        "requested" => [
          "data_element_id" => "scr_tb_sputum_test",
          "test_type_name" => "",
          "emr_test_type_name" => "Sputum Test Done",
          "info_type" => "requested",
        ],
        "date" => [
          "data_element_id" => "scr_tb_sputum_test_result_date",
          "emr_test_type_name" => "Date of Sputum Test Result",
          "info_type" => "date",
        ],
        "identifier" => [
          "data_element_id" => "scr_tb_sputum_test_result_no",
          "emr_test_type_name" => "Sputum Test Results No. ",
          "info_type" => "identifier",
        ],
        // seem not for lab to supply
        /*
        [
          "data_element_id" => "scr_tb_chest_xray",
          "emr_test_type_name" => "Chest Xray Required",
          "info_type" => "details",
        ],
        */
      ],
      [
        "result" => [
          "data_element_id" => "scr_malaria_test_result",
          "emr_test_type_name" => "Malaria Test Result",
          "emr_measure_range_aliases" => ["Negative", "Positive", "Invalid Result"],
          "info_type" => "result",
        ],
        "requested" => [
          "test_type_name" => "BS for mps",
          "data_element_id" => "anc_malaria_test",
          "emr_test_type_name" => "Tested for Malari",
          "info_type" => "requested",
        ],
        "date" => [
          "data_element_id" => "scr_malaria_test_result_date",
          "emr_test_type_name" => "Date of Test Result",
          "info_type" => "date",
        ],
      ],
      [
        "result" => [
          "data_element_id" => "anc_cervical_cancer_test_result",
          "emr_test_type_name" => "Cervical Cancer Test Result",
          "emr_measure_range_aliases" => null,
          "info_type" => "result",
        ],
        "requested" => [
          "test_type_name" => "",
          "data_element_id" => "anc_cervical_cancer_test",
          "emr_test_type_name" => "Tested for cervical cancer",
          "info_type" => "requested",
        ],
        "date" => [
          "data_element_id" => "anc_cervical_cancer_test_result_date",
          "emr_test_type_name" => "Date of test results",
          "info_type" => "date",
        ],
      ],
      [
        "result" => [
          "data_element_id" => "del_syphillis_test_results",
          "emr_test_type_name" => "Syphilis Test Results",
          "emr_measure_range_aliases" => ["Reactive", "non-reactive"],
          "info_type" => "result",
        ],
        "requested" => [
          "test_type_name" => "",
          "data_element_id" => "del_syphillis_test",
          "emr_test_type_name" => "Tested for Syphilis",
          "info_type" => "requested",
        ],
        "identifier" => [
          "data_element_id" => "del_syphillis_test_results_no",
          "emr_test_type_name" => "Syphilis Test Record Number",
          "info_type" => "identifier",
        ],
        "date" => [
          "data_element_id" => "del_syphillis_test_results_date",
          "emr_test_type_name" => "Date Test Results Received",
          "info_type" => "date",
        ],
      ],
      [
        "result" => [
          "data_element_id" => "pnc_Hb_test_results",
          "emr_test_type_name" => "HB Test Results",
          "emr_measure_range_aliases" => ["Positive", "Negative", "Not Available"],
          "info_type" => "result",
        ],
        "requested" => [
          "data_element_id" => "pnc_Hb_Test",
          "test_type_name" => "HB",
          "emr_test_type_name" => "HB Test Undertaken",
          "info_type" => "requested",
        ],
        "identifier" => [
          "data_element_id" => "pnc_Hb_test_results_no",
          "emr_test_type_name" => "HB (g/dl)",
          "info_type" => "identifier",
        ],
        "date" => [
          "data_element_id" => "pnc_hb_test_results_date",
          "emr_test_type_name" => "HB Test Results Date",
          "info_type" => "date",
        ],
        "details" => [
          "data_element_id" => "pnc_hb_test_results_no",
          "emr_test_type_name" => "HB Test Results No",
          "info_type" => "details",
        ],
      ],
      [
        "result" => [
          "data_element_id" => "pnc_urine_test_results",
          "emr_test_type_name" => "Test Results",
          "emr_measure_range_aliases" => null,
          "info_type" => "result",
        ],
        "requested" => [
          "test_type_name" => "",
          "data_element_id" => "pnc_urine_test",
          "emr_test_type_name" => "Urine Test Undertaken",
          "info_type" => "requested",
        ],
        "details" => [
          "data_element_id" => "pnc_urine_test_details",
          "emr_test_type_name" => "Details on what urine was tested for ",
          "info_type" => "details",
        ],
        "identifier" => [
          "data_element_id" => "pnc_urine_test_results_no",
          "emr_test_type_name" => "Test Results Number",
          "info_type" => "identifier",
        ],
        "date" => [
          "data_element_id" => "pnc_urine_test_results_date",
          "emr_test_type_name" => "Urine Test Results Date",
          "info_type" => "date",
        ],
      ],
      [
        "result" => [
          "data_element_id" => "pnc_hiv_test_results",
          "emr_test_type_name" => "Test Results",
          "emr_measure_range_aliases" => ["Reactive", "Non Reactive", "Indeterminate"],
          "info_type" => "result",
        ],
        "requested" => [
          "test_type_name" => "Rapid HIV test",
          "data_element_id" => "pnc_hiv_test",
          "emr_test_type_name" => "HIV Test Undertaken",
          "info_type" => "requested",
        ],
        "date" => [
          "data_element_id" => "pnc_hiv_test_results_date",
          "emr_test_type_name" => "Date Test Results Received",
          "info_type" => "date",
        ],
      ],
      [
        "          " => [
          "data_element_id" => "pnc_urine_protein_test",
          "emr_test_type_name" => "Protein Test Normal",
          "emr_measure_range_aliases" => null,
          "info_type" => "result",
          // please expect proper result type, numeric
          /*
          "emr_measure_range_aliases" => ["Yes","No"],
          "info_type" => "result",
          */
        ],
        "requested" => [
          "data_element_id" => "scr_urine_sugar_test",
          "test_type_name" => "",
          "emr_test_type_name" => "Urine Sugar Test Normal",
          "info_type" => "requested",
        ],
      ],
      [
        "          " => [
          "data_element_id" => "pnc_urinary_tract_infection",
          "emr_test_type_name" => "Evidence of Urinary Tract Infection",
          "emr_measure_range_aliases" => null,
          "info_type" => "result",
          // please expect proper result type, numeric
          /*
          "emr_measure_range_aliases" => ["Yes","No"],
          "info_type" => "result",
          */
        ],
        "requested" => [
          "data_element_id" => "scr_urine_sugar_test",
          "test_type_name" => "",
          "emr_test_type_name" => "Urine Sugar Test Normal",
          "info_type" => "requested",
        ],
      ],
      [
        "result" => [
          "data_element_id" => "tb_sputumsmear_test_results",
          "emr_test_type_name" => "Sputum Test Result",
          "emr_measure_range_aliases" => ["Positive", "Negative"],
          "info_type" => "result",
        ],
        "requested" => [
          "data_element_id" => "tb_sputumsmear_test",
          "test_type_name" => "",
          "emr_test_type_name" => "Sputum Test Done",
          "info_type" => "requested",
        ],
        "date" => [
          "data_element_id" => "tb_sputumsmear_test_date",
          "emr_test_type_name" => "Date of Sputum Test Result",
          "info_type" => "date",
        ],
        "identifier" => [
          "data_element_id" => "tb_sputumsmeartest_no",
          "emr_test_type_name" => "Sputum Test Results No. ",
          "info_type" => "identifier",
        ],
      ],
      [
        "result" => [
          "data_element_id" => "tb_gene_xpert_test_results",
          "emr_test_type_name" => "Gene Xpert Test Results",
          "emr_measure_range_aliases" => ["MTB detected", "rifampicin resistance not detected","MTB detected", "rifampicin resistance detected","MTB detected", "rifampicin resistance indeterminate","MTB not detected","Invalid/ no result / error"],
          "info_type" => "result",
        ],
        "requested" => [
          "test_type_name" => "",
          "data_element_id" => "tb_gene_xpert_lab_request",
          "emr_test_type_name" => "Gene Xpert Test Requested",
          "info_type" => "requested",
        ],
        "identifier" => [
          "data_element_id" => "tb_gene-xpert_test_resullt_no",
          "emr_test_type_name" => "Gene Xpert Test Result Number",
          "info_type" => "identifier",
        ],
        "date" => [
          "data_element_id" => "tb_gene_xpert_test_results_date",
          "emr_test_type_name" => "Date Gene Xpert Test Results Received",
          "info_type" => "date",
        ],
      ],
      [
        "result" => [
          "data_element_id" => "tb_chest_xray_results",
          "emr_test_type_name" => "Chest X-ray Results",
          "emr_measure_range_aliases" => null,
          "info_type" => "result",
        ],
        "requested" => [
          "test_type_name" => "",
          "data_element_id" => "tb_chest_xray",
          "emr_test_type_name" => "Chest X-ray Taken",
          "info_type"=>"requested",
        ],
        "date" => [
          "data_element_id" => "tb_chest_xray_date",
          "emr_test_type_name" => "Date of Chest X-ray",
          "info_type"=>"date",
        ],
      ],
      [
        "result" => [
          "data_element_id" => "tb_hiv_test_results",
          "emr_test_type_name" => "HIV Test Results",
          "emr_measure_range_aliases" => ["Reactive","Not Reactive","Indeterminate"],
          "info_type" => "result",
        ],
        "requested" => [
          "test_type_name" => "Rapid HIV test",
          "data_element_id" => "tb_hiv_test",
          "emr_test_type_name" => "HIV Test Performed",
          "info_type"=>"requested",
        ],
        "date" => [
          "data_element_id" => "tb_hiv_test_results_date",
          "emr_test_type_name" => "HIV Test Results Date",
          "info_type"=>"date",
        ],
        "number" => [
          "data_element_id" => "tb_hiv_test_results_no",
          "emr_test_type_name" => "HIV Test Results Number",
          "info_type"=>"number",
        ],
      ],
      [
        "result" => [
          "data_element_id" => "tb_sputumsmear_test_results",
          "emr_test_type_name" => "Sputum Test Resul",
          "emr_measure_range_aliases" => ["Positive", "Negative"],
          "info_type" => "result",
        ],
        "requested" => [
          "test_type_name" => "",
          "data_element_id" => "tb_sputumsmear_test",
          "emr_test_type_name" => "Sputum Test Done",
          "info_type" =>"requested",
        ],
        "date" => [
          "data_element_id" => "tb_sputumsmear_test_date",
          "emr_test_type_name" => "Date of Sputum Test Result",
          "info_type"=>"date",
        ],
        "number" => [
          "data_element_id" => "tb_sputumsmeartest_no",
          "emr_test_type_name" => "Sputum Test Results No. ",
          "info_type"=>"number",
        ],
      ],
      [
        "result" => [
          "data_element_id" => "tb_AFB_test_results",
          "emr_test_type_name" => "AFB Test Results",
          "emr_measure_range_aliases" => ["Positive", "Negative"],
          "info_type" => "result",
        ],
        "requested" => [
          "test_type_name" => "",
          "data_element_id" => "tb_AFB_test",
          "emr_test_type_name" => "AFB Test done",
          "info_type" => "requested",
        ],
        "date" => [
          "data_element_id" => "tb_AFB_test_results_date",
          "emr_test_type_name" => "AFB Test Results Date",
          "info_type" => "date",
        ],
        "identifier" => [
          "data_element_id" => "tb_AFB_test_results_no",
          "emr_test_type_name" => "AFB Test Results No",
          "info_type" => "identifier",
        ],
      ],
      [
        "result" => [
          "data_element_id" => "tb_gene_xpert_test_results",
          "emr_test_type_name" => "Gene Xpert Test Results",
          "emr_measure_range_aliases" => ["MTB detected", "rifampicin resistance not detected","MTB detected", "rifampicin resistance detected","MTB detected", "rifampicin resistance indeterminate","MTB not detected","Invalid/ no result / error"],
          "info_type" => "result",
        ],
        "requested" => [
          "test_type_name" => "",
          "data_element_id" => "tb_gene_xpert_lab_request",
          "emr_test_type_name" => "Gene Xpert Test Requested",
          "info_type" => "requested",
        ],
        "identifier" => [
          "data_element_id" => "tb_gene-xpert_test_resullt_no",
          "emr_test_type_name" => "Gene Xpert Test Result Number",
          "info_type" => "identifier",
        ],
        "date" => [
          "data_element_id" => "tb_gene_xpert_test_results_date",
          "emr_test_type_name" => "Date Gene Xpert Test Results Received",
          "info_type" => "date",
        ],
      ],
      [
        "result" => [
          "data_element_id" => "tb_culture_growth",
          "emr_test_type_name" => "Growth",
          "emr_measure_range_aliases" => ["Growth","No Growth"],
          "info_type" => "result",
        ],
        "requested" => [
          "test_type_name" => "",
          "data_element_id" => "tb_culture",
          "emr_test_type_name" => "Culture Taken",
          "info_type" => "requested",
        ],
        "details" => [
          "data_element_id" => "tb_culture_line",
          "emr_test_type_name" => "Culture for Line 1 or Line 2",
          // "emr_measure_range_aliases" => ["Line 1","Line 2"],
          "info_type" => "details",
        ],
        "date" => [
          "data_element_id" => "tb_culture_date",
          "emr_test_type_name" => "Date of culture test",
          "info_type" => "date",
        ],
      ],
      [
        "date" => [
          "data_element_id" => "tb_culture_results_date",
          "emr_test_type_name" => "Date Test Result Received",
          "info_type" => "date",
        ],
        "identifier" => [
          "data_element_id" => "tb_culture_test_no",
          "emr_test_type_name" => "Culture Test Number",
          "info_type" => "identifier",
        ],
        "result" => [
          "data_element_id" => "tb_culture_steptomycin",
          "emr_test_type_name" => "Culture/sensitivity results - Steptomycin (S)",
          "emr_measure_range_aliases" => ["Done", "no result","Sensitive","Reactive"],
          "info_type" => "result",
        ],
      ],
      [
        "result" => [
          "data_element_id" => "tb_culture_rifampicin",
          "emr_test_type_name" => "Culture/sensitivity results - Rifampicin ®",
          "emr_measure_range_aliases" => ["Done", "no result","Sensitive","Reactive"],
          "info_type" => "result",
        ],
      ],
      [
        "result" => [
          "data_element_id" => "tb_culture_isoniazid",
          "emr_test_type_name" => "Culture/sensitivity results - Isoniazid (H)",
          "emr_measure_range_aliases" => ["Done", "no result","Sensitive","Reactive"],
          "info_type" => "result",
        ],
      ],
      [
        "result" => [
          "data_element_id" => "tb_culture_ethambutol",
          "emr_test_type_name" => "Culture/sensitivity results - Ethambutol (E)",
          "emr_measure_range_aliases" => ["Done", "no result","Sensitive","Reactive"],
          "info_type" => "result",
        ],
      ],
      [
        "result" => [
          "data_element_id" => "tb_culture_kanamycin",
          "emr_test_type_name" => "Culture/sensitivity results - Kanamycin",
          "emr_measure_range_aliases" => ["Done", "no result","Sensitive","Reactive"],
          "info_type" => "result",
        ],
      ],
      [
        "result" => [
          "data_element_id" => "tb_culture_lerogloxacin",
          "emr_test_type_name" => "Culture/sensitivity results - Lerogloxacin (Quinalone)",
          "emr_measure_range_aliases" => ["Done", "no result","Sensitive","Reactive"],
          "info_type" => "result",
        ],
      ],
      [
        "result" => [
          "data_element_id" => "tb_lpa_results",
          "emr_test_type_name" => "LPA Results",
          "emr_measure_range_aliases" => ["Positive", "Negative"],
          "info_type" => "result",
        ],
        "requested" => [
          "test_type_name" => "",
          "data_element_id" => "tb_lpa",
          "emr_test_type_name" => "Line Probe Assay (LPA) Test",
          "info_type" => "requested",
        ],
        "details" => [
          "data_element_id" => "tb_lpa_line",
          "emr_test_type_name" => "LPA for Line 1 or Line 2",
          // "emr_measure_range_aliases" => ["Line 1","Line 2"],
          "info_type" => "details",
        ],
      ],
      [
        "result" => [
          "data_element_id" => "lpa_results_line1",
          "emr_test_type_name" => "LPA Results Line 1",
          "emr_measure_range_aliases" => ["Rfampicin","Isoniazid"],
          "info_type" => "result",
        ],
      ],
      [
        "result" => [
          "data_element_id" => "lpa_results_line2",
          "emr_test_type_name" => "LPA Results Line 2",
          "emr_measure_range_aliases" => ["Lerogloxacin (Quinalone)"," Kanamycin "],
          "info_type" => "result",
        ],
      ],
      [
        "result" => [
          "data_element_id" => "lpa_sensitivity_rifampicin",
          "emr_test_type_name" => "LPA Sensitivity Rifampicin",
          "emr_measure_range_aliases" => ["Not Sensitive","Sensitive"," Resistant "],
          "info_type" => "result",
        ],
      ],
      [
        "result" => [
          "data_element_id" => "lpa_sensitivity_isonazid",
          "emr_test_type_name" => "LPA Sensitivity Isonazid",
          "emr_measure_range_aliases" => ["Lerogloxacin (Quinalone)","Kanamycin"],
          "info_type" => "result",
        ],
      ],
      [
        "date" => [
          "data_element_id" => "tb_lpa_date",
          "emr_test_type_name" => "Date of LPA test",
          "info_type" => "date",
        ],
        "date" => [
          "data_element_id" => "tb_lpa_results_date",
          "emr_test_type_name" => "LPA Test Results Received",
          "info_type" => "date",
        ],
        "identifier" => [
          "data_element_id" => "tb_lpa_test_no",
          "emr_test_type_name" => "LPA Test Number",
          "info_type" => "identifier",
        ],
      ],
      [
        "result" => [
          "data_element_id" => "preart_hiv_kit1_results",
          "emr_test_type_name" => "HIV Kit 1 (Kenya) Dhirmine Results",
          "emr_measure_range_aliases" => ["Reactive","Not Reactive"],
          "info_type" => "result",
        ],
        "requested" => [
          "test_type_name" => "Rapid HIV test",
          "data_element_id" => "preart_hiv_test",
          "emr_test_type_name" => "HIV Test Performed",
          "info_type" => "requested",
        ],
        "date" => [
          "data_element_id" => "preart_hiv_date_results",
          "emr_test_type_name" => "HIV Test Results Date",
          "info_type" => "date",
        ],
        "identifier" => [
          "data_element_id" => "preart_hiv_results_no",
          "emr_test_type_name" => "HIV Test Results Number",
          "info_type" => "identifier",
        ],
      ],
      [
        "result" => [
          "data_element_id" => "preart_hiv_kit2_results",
          "emr_test_type_name" => "HIV Kit 2 (Kenya) First Response Results",
          "emr_measure_range_aliases" => ["Reactive","Not Reactive"],
          "info_type" => "result",
        ],
        "requested" => [
          "data_element_id" => "preart_hiv_kit2_results",
          "test_type_name" => "Rapid HIV test",
          "emr_test_type_name" => "HIV Kit 2 (Kenya) First Response Results",
          "info_type" => "requested",
        ],
      ],
      [
        "result" => [
          "data_element_id" => "preart_hiv_test_results",
          "emr_test_type_name" => "HIV Test Results",
          "emr_measure_range_aliases" => ["Reactive","Not Reactive","Indeterminate"],
          "info_type" => "result",
        ],
        "requested" => [
          "data_element_id" => "preart_hiv_test_results",
          "test_type_name" => "Rapid HIV test",
          "emr_test_type_name" => "HIV Test Results",
          "info_type" => "requested",
        ],
      ],
      [
        "result" => [
          "data_element_id" => "preart_CD4",
          "emr_test_type_name" => "CD4",
          "emr_measure_range_aliases" => null,
          "info_type" => "result",
        ],
        "requested" => [
          "data_element_id" => "preart_CD4",
          "test_type_name" => "",
          "emr_test_type_name" => "CD4",
          "info_type" => "requested",
        ],
      ],
      [
        "result" => [
          "data_element_id" => "pre-art_tb_test_results",
          "emr_test_type_name" => "TB Screening Results",
          "emr_measure_range_aliases" => ["No TB","Presumed TB","Active TB"],
          "info_type" => "result",
        ],
        "requested" => [
          "data_element_id" => "preart_tb_test",
          "test_type_name" => "",
          "emr_test_type_name" => "Screened for TB",
          "info_type" => "requested",
        ],
      ],
      [
        "result" => [
          "data_element_id" => "preart_tb_type",
          "emr_test_type_name" => "Tuberculosis Type",
          "emr_measure_range_aliases" => ["Pulmonary Negative","  Pulmonary Positive"," Extrapulmonary","  Multidrug resistant","  Extensive drug resistant","  Total drug resistant"],
          "info_type" => "result",
        ],
        "date" => [
          "test_type_name" => "",
          "data_element_id" => "preart_tb_test_results_date",
          "emr_test_type_name" => "TB Results Date",
          "info_type" => "date",
        ],
        "identifier" => [
          "data_element_id" => "preart_tb_test_results_no",
          "emr_test_type_name" => "TB Test Results Number",
          "info_type" => "identifier",
        ],
      ],
      [
        "result" => [
          "data_element_id" => "art_CD4_results",
          "emr_test_type_name" => "CD4 Results",
          "emr_measure_range_aliases" => null,
          "info_type" => "result",
        ],
        "requested" => [
          "test_type_name" => "",
          "data_element_id" => "art_CD4_lab",
          "emr_test_type_name" => "CD4 Lab Request",
          "info_type" => "requested",
        ],
        "identifier" => [
          "data_element_id" => "art_CD4_test_no",
          "emr_test_type_name" => "CD4 Test No",
          "info_type" => "identifier",
        ],
        "date" => [
          "data_element_id" => "art_CD4_test_results_date",
          "emr_test_type_name" => "CD4 Test Results Date",
          "info_type" => "date",
        ],
      ],
      [
        "result" => [
          "data_element_id" => "art_viral_load_lab",
          "emr_test_type_name" => "Viral Load Lab Request",
          "emr_measure_range_aliases" => null,
          "info_type" => "result",
        ],
        "requested" => [
          "test_type_name" => "",
          "data_element_id" => "art_viral_load_lab",
          "emr_test_type_name" => "Viral Load Lab Request",
          "info_type" => "requested",
        ],
      ],
      "result" => [
        "requested" => [
          "data_element_id" => "art_viral_load_test_results",
          "emr_test_type_name" => "Viral Load Test Results",
          "emr_measure_range_aliases" => null,
          "info_type" => "result",
        ],
        "identifier" => [
          "test_type_name" => "",
          "data_element_id" => "art_viral_load_lab",
          "emr_test_type_name" => "Viral Load Lab Request",
          "info_type" => "requested",
        ],
        "date" => [
          "data_element_id" => "art_viral_load_test_no",
          "emr_test_type_name" => "Viral Load Test No",
          "info_type" => "identifier",
        ],
        "          " => [
          "data_element_id" => "art_viral_load_test_results_date",
          "emr_test_type_name" => "Viral Load Test Results Date",
          "info_type" => "date",
        ],
          // this decision should be made on the mHealth side, I suppose
          /*
        [
          "data_element_id" => "art_viral_load_suppressed",
          "emr_test_type_name" => "Viral Load Suppressed <1000 copies/mL",
          "emr_measure_range_aliases" => ["Yes","No"],
          "info_type" => "result",
          "info_type" => "details",
        ],
          */
      ],
      [
        "result" => [
          "data_element_id" => "art_Hb",
          "emr_test_type_name" => "HB (g/dl)",
          "emr_measure_range_aliases" => null,
          "info_type" => "result",
        ], 
        "details" => [
          "test_type_name" => "HB",
          "data_element_id" => "art_hb_test",
          "emr_test_type_name" => "HB Test Undertaken",
          "info_type" => "details",
        ],
        "date" => [
          "data_element_id" => "art_hb_test_results_date",
          "emr_test_type_name" => "HB Test Results Date",
          "info_type" => "date",
        ],
        "identifier" => [
          "data_element_id" => "art_hb_test_results_no",
          "emr_test_type_name" => "HB Test Results No",
          "info_type" => "identifier",
        ],
      ],
      [
        "result" => [
          "data_element_id" => "art_sputum_results",
          "emr_test_type_name" => "Sputum Test Resul",
          "emr_measure_range_aliases" => ["Positive", "Negative"],
          "info_type" => "result",
        ], 
        "requested" => [
          "test_type_name" => "",
          "data_element_id" => "art_sputum_test",
          "emr_test_type_name" => "Sputum Test Done",
          "info_type" => "requested",
        ],
      ],
      [
        "result" => [
          "data_element_id" => "art_gene_xpert_results",
          "emr_test_type_name" => "Gene Xpert Test Results",
          "emr_measure_range_aliases" => ["MTB detected", "rifampicin resistance not detected","MTB detected", "rifampicin resistance detected","MTB detected", "rifampicin resistance indeterminate","MTB not detected","Invalid/ no result / error"],
          "info_type" => "result",
        ], 
        "requested" => [
          "data_element_id" => "art_gene_xpert_lab_request",
          "test_type_name" => "",
          "emr_test_type_name" => "Gene Xpert Test Done",
          "info_type" => "requested",
        ],
        "identifier" => [
          "data_element_id" => "art_gene-xpert_test_resullt_no",
          "emr_test_type_name" => "Gene Xpert Test Result No",
          "info_type" => "identifier",
        ],
        "date" => [
          "data_element_id" => "art_gene_xpert_test_results_date",
          "emr_test_type_name" => "Gene Xpert Test Results Date",
          "info_type" => "date",
        ],
      ],
      [
        "result" => [
          "data_element_id" => "art_liver_test_results",
          "emr_test_type_name" => "Liver Function Test Results",
          "emr_measure_range_aliases" => ["Normal","Low","High"],
          "info_type" => "result",
        ],
        "requested" => [
          "test_type_name" => "LFTS",
          "data_element_id" => "art_liver_test",
          "emr_test_type_name" => "Liver Function Test Requested",
          "info_type" => "requested",
        ],
        "details" => [
          "data_element_id" => "art_liver_test_results_details",
          "emr_test_type_name" => "Liver Function Test Restuls Details",
          "info_type" => "details",
        ],
        "identifier" => [
          "data_element_id" => "art_liver_test_results_no",
          "emr_test_type_name" => "Liver Function Test Results No",
          "info_type" => "identifier",
        ],
        "date" => [
          "data_element_id" => "art_liver_test_results_date",
          "emr_test_type_name" => "Date Liver Function Test Results Received",
          "info_type" => "date",
        ],
      ],
      [
        "result" => [
          "data_element_id" => "art_renal_test_results",
          "emr_test_type_name" => "Renal Function Test Results",
          "emr_measure_range_aliases" => ["Normal","Low"],
          "info_type" => "result",
        ],
        "requested" => [
          "test_type_name" => "RFTS",
          "data_element_id" => "art_renal_test",
          "emr_test_type_name" => "Renal Function Test Requested",
          "info_type" => "requested",
        ],
        "details" => [
          "data_element_id" => "art_renal_test_results_details",
          "emr_test_type_name" => "Renal Function Test Restuls Details",
          "info_type" => "details",
        ],
        "identifier" => [
          "data_element_id" => "art_renal_test_results_no",
          "emr_test_type_name" => "Renal Function Test Results No",
          "info_type" => "identifier",
        ],
        "date" => [
          "data_element_id" => "art_renal_test_results_date",
          "emr_test_type_name" => "Date Renal Function Test Results Received",
          "info_type" => "date",
        ],
      ],
      [
        "result" => [
          "data_element_id" => "art_preg_test_results",
          "emr_test_type_name" => "Pregnancy Test Results",
          "emr_measure_range_aliases" => ["Positive","Negative","Inconclusive"],
          "info_type" => "result",
        ], 
        "requested" => [
          "test_type_name" => "Pregnancy test",
          "data_element_id" => "art_preg_test",
          "emr_test_type_name" => "Pregnancy Test Requested",
          "info_type" => "requested",
        ],
        "details" => [
          "data_element_id" => "art_preg_test_results_details",
          "emr_test_type_name" => "Pregnancy Test Results Details",
          "info_type" => "details",
        ],
        "identifier" => [
          "data_element_id" => "art_preg_test_results_no",
          "emr_test_type_name" => "Pregnancy Test Results No",
          "info_type" => "identifier",
        ],
        "date" => [
          "data_element_id" => "art_preg_test_results_date",
          "emr_test_type_name" => "Date Pregnancy Test Results Received",
          "info_type" => "date",
        ],
      ],
      [
        "result" => [
          "data_element_id" => "cc_VIA_results",
          "emr_test_type_name" => "VIA / VILI Results",
          "emr_measure_range_aliases" => ["VIA Negative","VIA Positive","VILI Negative","VILI Positive","Suspicious for Cancer"],
          "info_type" => "result",
        ], 
        "requested" => [
          "test_type_name" => "",
          "data_element_id" => "cc_VIA",
          "emr_test_type_name" => "VIA/VILI Screening Undertaken",
          "info_type" => "requested",
        ],
      ],
      [
        "result" => [
          "data_element_id" => "cc_PapSmear_results",
          "emr_test_type_name" => "Pap Smear Results",
          "emr_measure_range_aliases" => ["Normal","Pre-Invasive Cancer","Invasive Cancer"],
          "info_type" => "result",
        ],
        "requested" => [
          "test_type_name" => "",
          "data_element_id" => "cc_PapSmear",
          "emr_test_type_name" => "Pap Smear Undertaken",
          "info_type" => "requested",
        ],
        "date" => [
          "data_element_id" => "cc_PapSmear_results_date",
          "emr_test_type_name" => "Date of test results",
          "info_type" => "date",
        ],
        "identifier" => [
          "data_element_id" => "cc_PapSmear_results_no",
          "emr_test_type_name" => "Test Number",
          "info_type" => "identifier",
        ],
  
      ],
      [
        "result" => [
          "data_element_id" => "cc_HPV_results",
          "emr_test_type_name" => "HPV Test Results",
          "emr_measure_range_aliases" => ["Negative","Positive"],
          "info_type" => "result",
        ],
        "requested" => [
          "test_type_name" => "",
          "data_element_id" => "cc_HPV",
          "emr_test_type_name" => "HPV Test Undertaken",
          "info_type" => "requested",
        ],
        "date" => [
          "data_element_id" => "cc_HPV_results_date",
          "emr_test_type_name" => "Date of test result",
          "info_type" => "date",
        ],
        "identifier" => [
          "data_element_id" => "cc_HPV_results_no",
          "emr_test_type_name" => "HPV Test Number",
          "info_type" => "identifier",
        ],
      ],
      [
        "result" => [
          "data_element_id" => "cc_colposcopy_results",
          "emr_test_type_name" => "Colposcopy Results",
          "emr_measure_range_aliases" => ["Satisfactory","Unsatisfactory","Normal","Acetowhite","eukoplakia","Punctation","Abnormal"],
          "info_type" => "result",
        ],
        "requested" => [
          "test_type_name" => "",
          "data_element_id" => "cc_cervicography",
          "emr_test_type_name" => "Cervicography undertaken",
          "info_type" => "requested",
        ],
      ],
      [
        "result" => [
          "data_element_id" => "fp_hiv_test_results_repeatable",
          "emr_test_type_name" => "Test Results",
          "emr_measure_range_aliases" => ["Reactive", "Non Reactive", "Indeterminate"],
          "info_type" => "result",
        ],
        "requested" => [
          "test_type_name" => "Rapid HIV test",
          "data_element_id" => "fp_hiv_test_repeatable",
          "emr_test_type_name" => "HIV Test Undertaken",
          "info_type" => "requested",
        ],
        "date" => [
          "data_element_id" => "fp_hiv_test_results_date",
          "emr_test_type_name" => "Date Test Results Received",
          "info_type" => "date",
        ],
      ],
      "relevant_type" => [
        "result" => [
          "data_element_id" => "fp_cervical_cancer_result_repeatable",
          "emr_test_type_name" => "Cervical Cancer Test Result",
          "emr_measure_range_aliases" => ["Positive"," Negative"," Suspected","Pap Smear Normal"," Low-grade squamous intraepithelial lesions (LSIL)"," High-grade squamous intraepithelial lesions (HSIL)","Overt cancer"],
          "info_type" => "result",
        ],
        "requested" => [
          "test_type_name" => "",
          "data_element_id" => "fp_cervical_cancer_screening_repeatable",
          "emr_test_type_name" => "Tested for cervical cancer",
          "info_type" => "requested",
        ],
        "details" => [
          "data_element_id" => "fp_cervical_cancer_screening_method",
          "emr_test_type_name" => "Cervical Cancer Screening Method",
          // "emr_measure_range_aliases" => ["Visual Inspection with Acetic Acid (VIA)"," Visual Inspection with Lugols Iodine (VILI)","  Pap Smear"," Human papillomavirus (HPV) Test"],
          "info_type" => "details",
        ],
      ],
      [
        "result" => [
          "data_element_id" => "opd_hiv_test_results",
          "emr_test_type_name" => "HIV Test Results",
          "emr_measure_range_aliases" => ["Reactive","Not Reactive","Indeterminate"],
          "info_type" => "result",
        ],
        "requested" => [
          "test_type_name" => "Rapid HIV test",
          "data_element_id" => "opd_hiv_test",
          "emr_test_type_name" => "HIV Test Performed",
          "info_type" => "requested",
        ],
        "date" => [
          "data_element_id" => "opd_hiv_results_date",
          "emr_test_type_name" => "HIV Test Results Date",
          "info_type" => "date",
        ],
        "identifier" => [
          "data_element_id" => "opd_hiv_results_no",
          "emr_test_type_name" => "HIV Test Results Number",
          "info_type" => "identifier",
        ],
      ],
      [
        "result" => [
            // what test is this supposed to be
          "data_element_id" => "opd_tb_test_results",
          "emr_test_type_name" => "TB Screening Results",
          "emr_measure_range_aliases" => ["Positive","Negative"],
          "info_type" => "result",
        ],
        "requested" => [
          "data_element_id" => "opd_tb_screening",
          "test_type_name" => "",
          "emr_test_type_name" => "Screened for TB",
           "info_type" => "requested",
        ],
        "date" => [
          "data_element_id" => "opd_tb_test_results_date",
          "emr_test_type_name" => "TB Test Results Date",
          "info_type" => "date",
        ],
        "identifier" => [
          "data_element_id" => "opd_tb_test_results_no",
          "emr_test_type_name" => "TB Test Results No",
          "info_type" => "identifier",
        ],
      ],
      [
        "result" => [
          "data_element_id" => "popc_hiv_test_results",
          "emr_test_type_name" => "HIV Test Results",
          "emr_measure_range_aliases" => ["Reactive", "Non Reactive", "Indeterminate"],
          "info_type" => "result",
        ],
        "requested" => [
          "data_element_id" => "popc_hiv_test",
          "test_type_name" => "Rapid HIV test",
          "emr_test_type_name" => "Was a HIV Test performed",
          "info_type" => "requested",
        ],
        "date" => [
          "data_element_id" => "popc_hiv_results_date",
          "emr_test_type_name" => "Date Test Results Received",
          "info_type" => "date",
        ],
        "identifier" => [
          "data_element_id" => "popc_hiv_results_no",
          "emr_test_type_name" => "HIV Test Results Number",
          "info_type" => "identifier",
        ],
      ],
      [
        "result" => [
          "data_element_id" => "popc_electrophoresis_test_results",
          "emr_test_type_name" => "Electrophoresis Test Results",
          "emr_measure_range_aliases" => ["Positive", "Negative", "Not Available"],
          "info_type" => "result",
        ],
        "requested" => [
          "test_type_name" => "",
          "data_element_id" => "popc_electrophoresis_test",
          "emr_test_type_name" => "Electrophoresis Test Undertaken",
           "info_type" => "requested",
        ],
        "date" => [
          "data_element_id" => "popc_electrophoresis_test_results_date",
          "emr_test_type_name" => "Electrophoresis Test Results Date",
           "info_type" => "date",
        ],
        "identifier" => [
          "data_element_id" => "popc_electrophoresis_test_results_no",
          "emr_test_type_name" => "Electrophoresis Test Results Number",
           "info_type" => "identifier",
        ],
      ],
      [
        "result" => [
          "data_element_id" => "popc_hb",
          "emr_test_type_name" => "HB (g/dl)",
          "emr_measure_range_aliases" => null,
          "info_type" => "result",
        ],
        "requested" => [
          "test_type_name" => "HB",
          "data_element_id" => "popc_hb",
          "emr_test_type_name" => "HB (g/dl)",
          "info_type" => "requested",
        ],
      ],
      [
        "result" => [
          "data_element_id" => "popc_haemogram_test_results",
          "emr_test_type_name" => "Haemogram Test Results",
          "emr_measure_range_aliases" => ["Normal/ Abnormal"],
          "info_type" => "result",
        ],
        "requested" => [
          "data_element_id" => "popc_haemogram_test",
          "test_type_name" => "",
          "emr_test_type_name" => "Full Haemogram Undertaken",
          "info_type" => "requested",
        ],
        "details" => [
          "data_element_id" => "popc_haemogram_test_result_details",
          "emr_test_type_name" => "Haemogram Test Result Details",
          "info_type" => "details",
        ],
        "date" => [
          "data_element_id" => "popc_haemogram_test_results_date",
          "emr_test_type_name" => "Haemogram Test Results Date",
          "info_type" => "date",
        ],
        "identifier" => [
          "data_element_id" => "popc_haemogram_test_results_no",
          "emr_test_type_name" => "Haemogram Test Results Number",
          "info_type" => "identifier",
        ],
      ],
      [
        "result" => [
          "data_element_id" => "popc_sickling_test_results",
          "emr_test_type_name" => "Sickling Test Results",
          "emr_measure_range_aliases" => ["Positive", "Negative"],
          "info_type" => "result",
        ],
        "requested" => [
          "data_element_id" => "popc_sickling_test",
          "test_type_name" => "Sickling Test",
          "emr_test_type_name" => "Sickling Test Undertaken",
          "info_type" => "requested",
        ],
        "date" => [
          "data_element_id" => "popc_sickling_test_results_date",
          "emr_test_type_name" => "Sickling Test Results Date",
          "info_type" => "date",
        ],
        "identifier" => [
          "data_element_id" => "popc_sickling_test_results_no",
          "emr_test_type_name" => "Sickling Test Results Number",
          "info_type" => "identifier",
        ],
      ],
    ];

    try {
      foreach ($testTypes as $testType) {

        // should have result_data_element_id|requested_data_element_id
        if (array_key_exists('result', $testType) &&
          array_key_exists('requested', $testType)) {

          // will help tell what is failing and why
          echo $testType['requested']['data_element_id']."\n";

          $mapTestTypeStore = $this->mapTestTypeStore(
            $client_name = 'ML4Afrika',
            $test_type_name = $testType['requested']['test_type_name'],
            $emr_test_type_name = $testType['requested']['data_element_id'],
            $system = 'http://www.mhealth4afrika.eu/fhir/StructureDefinition/dataElementCode',
            $result_data_element_id = $testType['result']['data_element_id'],
            $number_data_element_id = (array_key_exists("identifier",$testType)['identifier']) ? $testType['identifier']['data_element_id'] : null,
            $detail_data_element_id = (array_key_exists("details",$testType)['details']) ? $testType['details']['data_element_id'] : null,
            $requested_data_element_id = $testType['requested']['data_element_id'],
            $emr_measure_range_aliases = $testType['result']['emr_measure_range_aliases']
          );
        }else{
          // does not qualify functions to identify them
        }
      }
// echo "first";
    } catch (\GuzzleHttp\Exception\ClientException $e) {
      // status 401
      echo "Token Expired\n";
      $clientLogin = new Client();
      // send results for individual tests for starters
      $loginResponse = $clientLogin->request('POST', env('BLIS_LOGIN_URL', 'http://blis3.local/api/tpa/login'), [
        'headers' => [
          'Accept' => 'application/json',
          'Content-type' => 'application/json'
      ],
        'json' => [
          // 'email' => 'admin',//test server
          // 'password' => 'district'//test server
          'email' => 'ml4afrika@emr.dev',
          'password' => 'password'
      ],
      ]);
      if ($loginResponse->getStatusCode() == 200) {
        $accessToken = json_decode($loginResponse->getBody()->getContents())->access_token;
        echo $accessToken."\n";
        \App\ThirdPartyApp::where('email','ml4afrika@play.dev')->update(['access_token' => $accessToken]);

      }else{
        dd('real problem up in here');
      }
    }
  }
  public function mapTestTypeStore(
    $client_name,
    $test_type_name,
    $emr_test_type_name,
    $system,
    $result_data_element_id,
    $number_data_element_id,
    $detail_data_element_id,
    $requested_data_element_id,
    $emr_measure_range_aliases
  ){

    $accessToken = \App\ThirdPartyApp::where('email','ml4afrika@play.dev')->first()->access_token;
    $client = new Client();
    $data =[
      "client_name" => $client_name,
      "test_type_name" => $test_type_name,
      "emr_alias" => $requested_data_element_id,
      "system" => $system,
      "request_code" => $requested_data_element_id,
      "result_code" => $result_data_element_id,
      "display" => $emr_test_type_name,
      "emr_measure_range_aliases" => $emr_measure_range_aliases,
    ];

    $response = $client->request('POST',
      env('BLIS_MAP_TESTTYPE_STORE_URL',
        'http://blis3.local/api/maptesttypebynames'), [
      'headers' => [
        'Accept' => 'application/json',
        'Content-type' => 'application/json',
        'Authorization' => 'Bearer '.$accessToken,
      ],
      'json' => $data,
    ]);
    return $response;
  }

}
