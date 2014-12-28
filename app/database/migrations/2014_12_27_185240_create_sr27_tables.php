<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSr27Tables extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		DB::transaction(function() {

			/**
			This file (Table 10) contains codes indicating the type of data (analytical, calculated, assumed zero, and so on) in the Nutrient Data file. To improve the usability of the database and to provide values for the FNDDS, NDL staff imputed nutrient values for a number of proximate components, total dietary fiber, total sugar, and vitamin and mineral values.
			**/
			Schema::create('src_cd', function($tbl) {
				// 2-digit code.
				$tbl->string('src_cd', 2);
				// Description of source code that identifies the type of nutrient data.
				$tbl->string('srccd_desc', 60);

				// PK
				$tbl->primary('src_cd');
			});

			/**
			This file provides information on how the nutrient values were determined. The file contains the derivation codes and their descriptions.
			**/
			Schema::create('deriv_cd', function($tbl) {
				// Derivation Code.
				$tbl->string('deriv_cd', 4);
				// Description of derivation code giving specific information on how the value was determined.
				$tbl->string('deriv_desc', 120);

				// PK
				$tbl->primary('deriv_cd');
			});

			/**
			This file contains the nutrient values and information about the values, including expanded statistical information.
			**/
			Schema::create('nut_data', function($tbl) {
				// 5-digit Nutrient Databank number.
				$tbl->string('ndb_no', 5);
				// Unique 3-digit identifier code for a nutrient.
				$tbl->string('nutr_no', 3);
				// Amount in 100 grams, edible portion.
				$tbl->double('nutr_val', 10, 3);
				// Number of data points (previously called Sample_Ct) is the number of analyses used to calculate the nutrient value. If the number of data points is 0, the value was calculated or imputed.
				$tbl->integer('num_data_pts');
				// Standard error of the mean. Null if cannot be calculated. The standard error is also not given if the number of data points is less than three.
				$tbl->double('std_error', 8, 3)->nullable();
				// Code indicating type of data.
				$tbl->string('src_cd', 2);
				// Data Derivation Code giving specific information on how the value is determined. This field is populated only for items added or updated starting with SR14.
				$tbl->string('deriv_cd', 4)->nullable();
				// NDB number of the item used to calculate a missing value. Populated only for items added or updated starting with SR14.
				$tbl->string('ref_ndb_no', 5)->nullable();
				// Indicates a vitamin or mineral added for fortification or enrichment. This field is populated for ready-to- eat breakfast cereals and many brand-name hot cereals in food group 8.
				$tbl->string('add_nutr_mark', 1)->nullable();
				// Number of studies.
				$tbl->integer('num_studies')->nullable();
				// Minimum value.
				$tbl->double('min', 10, 3)->nullable();
				// Maximum value.
				$tbl->double('max', 10, 3)->nullable();
				// Degrees of freedom.
				$tbl->integer('df')->nullable();
				// Lower 95% error bound.
				$tbl->double('low_eb', 10, 3)->nullable();
				// Upper 95% error bound.
				$tbl->double('up_eb', 10, 3)->nullable();
				// Statistical comments. See definitions below.
				$tbl->string('stat_cmt', 10)->nullable();
				// Indicates when a value was either added to the database or last modified.
				$tbl->string('addmod_date', 10)->nullable();
				// Confidence Code indicating data quality, based on evaluation of sample plan, sample handling, analytical method, analytical quality control, and number of samples analyzed. Not included in this release, but is planned for future releases.
				$tbl->string('cc', 1)->nullable();

				// PK
				$tbl->primary([
					'ndb_no',
					'nutr_no'
				]);

				// FKs
				// $tbl->foreign('src_cd')->references('src_cd')->on('src_cd');
				// $tbl->foreign('deriv_cd')->references('deriv_cd')->on('deriv_cd');
			});

			/**
			This file is a support file to the Food Description file and contains a list of food groups used in SR27 and their descriptions.
			**/
			Schema::create('fdgrp_cd', function($tbl) {
				// 4-digit code identifying a food group. Only the first 2 digits are currently assigned. In the future, the last 2 digits may be used. Codes may not be consecutive.
				$tbl->string('fdgrp_cd', 4);
				// Name of food group.
				$tbl->string('fdgrp_desc', 60);

				// PK
				$tbl->primary('fdgrp_cd');
			});

			/**
			This file contains long and short descriptions and food group designators for all food items, along with common names, manufacturer name, scientific name, percentage and description of refuse, and factors used for calculating protein and kilocalories, if applicable. Items used in the FNDDS are also identified by value of “Y” in the Survey field.
			**/
			Schema::create('food_des', function($tbl) {
				// 5-digit Nutrient Databank number that uniquely identifies a food item. If this field is defined as numeric, the leading zero will be lost.
				$tbl->string('ndb_no', 5);
				// 4-digit code indicating food group to which a food item belongs.
				$tbl->string('fdgrp_cd', 4);
				// 200-character description of food item.
				$tbl->string('long_desc', 200);
				// 60-character abbreviated description of food item. Generated from the 200-character description using abbreviations in Appendix A. If short description is longer than 60 characters, additional abbreviations are made.
				$tbl->string('short_desc', 60);
				// Other names commonly used to describe a food, including local or regional names for various foods, for example, “soda” or “pop” for “carbonated beverages.”
				$tbl->string('comname', 100)->nullable();
				// Indicates the company that manufactured the product, when appropriate.
				$tbl->string('manufacname', 65)->nullable();
				// Indicates if the food item is used in the USDA Food and Nutrient Database for Dietary Studies (FNDDS) and thus has a complete nutrient profile for the 65 FNDDS nutrients.
				$tbl->string('survey', 1)->nullable();
				// Description of inedible parts of a food item (refuse), such as seeds or bone.
				$tbl->string('ref_desc', 135)->nullable();
				// Percentage of refuse.
				$tbl->integer('refuse')->nullable();
				// Scientific name of the food item. Given for the least processed form of the food (usually raw), if applicable.
				$tbl->string('sciname', 65)->nullable();
				// Factor for converting nitrogen to protein.
				$tbl->double('n_factor', 4, 2)->nullable();
				// Factor for calculating calories from protein.
				$tbl->double('pro_factor', 4, 2)->nullable();
				// Factor for calculating calories from fat.
				$tbl->double('fat_factor', 4, 2)->nullable();
				// Factor for calculating calories from carbohydrate.
				$tbl->double('cho_factor', 4, 2)->nullable();

				// PK
				$tbl->primary('ndb_no');

				// FKs
				// $tbl->foreign('fdgrp_cd')->references('fdgrp_cd')->on('fdgrp_cd');
				// $tbl->foreign('ndb_no')->references('ndb_no')->on('nut_data');
			});

			/**
			This file is a support file to the LanguaL Factor file and contains the descriptions for only those factors used in coding the selected food items codes in this release of SR.
			**/
			Schema::create('langdesc', function($tbl){
				// The LanguaL factor from the Thesaurus. Only those codes used to factor the foods contained in the LanguaL Factor file are included in this file
				$tbl->string('factor_code', 5);
				// The description of the LanguaL Factor Code from the thesaurus
				$tbl->string('description', 140);

				// PK
				$tbl->primary('factor_code');
			});

			/**
			This file is a support file to the Food Description file and contains the factors from the LanguaL Thesaurus used to code a particular food.
			**/
			Schema::create('langual', function($tbl) {
				// 5-digit Nutrient Databank number that uniquely identifies a food item. If this field is defined as numeric, the leading zero will be lost.
				$tbl->string('ndb_no', 5);
				// The LanguaL factor from the Thesaurus
				$tbl->string('factor_code', 5);

				// PK
				$tbl->primary([
					'ndb_no',
					'factor_code'
				]);

				// FKs
				// $tbl->foreign('ndb_no')->references('ndb_no')->on('food_des');
				// $tbl->foreign('factor_code')->references('factor_code')->on('langdesc');
			});

			/**
			This file is a support file to the Nutrient Data file. It provides the 3-digit nutrient code, unit of measure, INFOODS tagname, and description.
			- Links to the Nutrient Data file by Nutr_No
			**/
			Schema::create('nutr_def', function($tbl) {
				// Unique 3-digit identifier code for a nutrient.
				$tbl->string('nutr_no', 3);
				// Units of measure (mg, g, μg, and so on).
				$tbl->string('units', 7);
				// International Network of Food Data Systems (INFOODS) Tagnames.† A unique abbreviation for a nutrient/food component developed by INFOODS to aid in the interchange of data.
				$tbl->string('tagname', 20)->nullable();
				// Name of nutrient/food component.
				$tbl->string('nutrdesc', 60);
				// Number of decimal places to which a nutrient value is rounded.
				$tbl->string('num_dec', 1);
				// Used to sort nutrient records in the same order as various reports produced from SR.
				$tbl->integer('sr_order');

				// PK
				$tbl->primary('nutr_no');

				// FKs
				// $tbl->foreign('nutr_no')->references('nutr_no')->on('nut_data');
			});

			/**
			This file (Table 12) contains the weight in grams of a number of common measures for each food item.
			**/
			Schema::create('weight', function($tbl) {
				// 5-digit Nutrient Databank number.
				$tbl->string('ndb_no', 5);
				// Sequence number.
				$tbl->string('seq', 2);
				// Unit modifier (for example, 1 in “1 cup”).
				$tbl->double('amount', 5, 2);
				// Description (for example, cup, diced, and 1-inch pieces).
				$tbl->string('msre_desc', 84);
				// Gram weight.
				$tbl->double('gm_wgt', 7, 1);
				// Number of data points.
				$tbl->integer('num_data_pts')->nullable();
				// Standard deviation.
				$tbl->double('std_dev', 7, 3)->nullable();

				// PK
				$tbl->primary([
					'ndb_no',
					'seq'
				]);
			});

			/**
			This file (Table 13) contains additional information about the food item, household weight, and nutrient value.
			**/
			Schema::create('footnote', function($tbl) {
				// 5-digit Nutrient Databank number.
				$tbl->string('ndb_no', 5);
				// Sequence number. If a given footnote applies to more than one nutrient number, the same footnote number is used. As a result, this file cannot be indexed.
				$tbl->string('footnt_no', 4);
				// Type of footnote.
				$tbl->string('footnt_typ', 1);
				// Unique 3-digit identifier code for a nutrient to which footnote applies.
				$tbl->string('nutr_no', 3)->nullable();
				// Footnote text.
				$tbl->string('footnt_txt', 200);
			});

			/**
			This file (Table 15) provides a citation to the DataSrc_ID in the Sources of Data Link file.
			**/
			Schema::create('data_src', function($tbl) {
				// Unique number identifying the reference/source.
				$tbl->string('datasrc_id', 6);
				// List of authors for a journal article or name of sponsoring organization for other documents.
				$tbl->string('authors', 255)->nullable();
				// Title of article or name of document, such as a report from a company or trade association.
				$tbl->string('title', 255)->nullable();
				// Year article or document was published.
				$tbl->integer('year')->nullable();
				// Name of the journal in which the article was published.
				$tbl->string('journal', 135)->nullable();
				// Volume number for journal articles, books, or reports; city where sponsoring organization is located.
				$tbl->string('vol_city', 16)->nullable();
				// Issue number for journal article; State where the sponsoring organization is located.
				$tbl->string('issue_state', 5)->nullable();
				// Starting page number of article/document.
				$tbl->string('start_page', 5)->nullable();
				// Ending page number of article/document.
				$tbl->string('end_page', 5)->nullable();

				// PK
				$tbl->primary('datasrc_id');
			});

			/**
			This fiel is used to link the Nutrient Data file with the Sources of Data table. It is needed to resolve the many-to- many relationship between the two tables.
			**/
			Schema::create('datsrcln', function($tbl) {
				// 5-digit Nutrient Databank number.
				$tbl->string('ndb_no', 5);
				// Unique 3-digit identifier code for a nutrient.
				$tbl->string('nutr_no', 3);
				// Unique ID identifying the reference/source.
				$tbl->string('datasrc_id', 6);

				$tbl->primary([
					'ndb_no',
					'nutr_no',
					'datasrc_id'
				]);

				// FKs
				// $tbl->foreign('ndb_no')->references('ndb_no')->on('nut_data');
				// $tbl->foreign('nutr_no')->references('nutr_no')->on('nut_data');
				// $tbl->foreign('datasrc_id')->references('datasrc_id')->on('data_src');
			});
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		DB::transaction(function() {
			Schema::drop('datsrcln');
			Schema::drop('data_src');
			Schema::drop('footnote');
			Schema::drop('weight');
			Schema::drop('nutr_def');
			Schema::drop('langual');
			Schema::drop('langdesc');
			Schema::drop('food_des');
			Schema::drop('fdgrp_cd');
			Schema::drop('nut_data');
			Schema::drop('deriv_cd');
			Schema::drop('src_cd');
		});
	}

}
