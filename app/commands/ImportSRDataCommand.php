<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class ImportSRDataCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'import:data';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Import a new SR data directory.';

	/**
	 * The list of files to import, in the correct import order.
	 * 
	 * @var array [ {filename} ] = {tablename}
	 */
	protected $order = [
		'SRC_CD'   => 'src_cd',
		'DERIV_CD' => 'deriv_cd',
		'NUT_DATA' => 'nut_data',
		'FD_GROUP' => 'fdgrp_cd',
		'FOOD_DES' => 'food_des',
		'LANGDESC' => 'langdesc',
		'LANGUAL'  => 'langual',
		'NUTR_DEF' => 'nutr_def',
		'WEIGHT'   => 'weight',
		'FOOTNOTE' => 'footnote',
		'DATA_SRC' => 'data_src',
		'DATSRCLN' => 'datsrcln',
	];

	/**
	 * The normalized source directory
	 *
	 * @var string
	 */
	protected $directory = '';

	/**
	 * Flag to determine if we should continue
	 *
	 * @var boolean
	 */
	protected $continue = true;

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
	public function fire()
	{
		// Set up data
		$this->directory = rtrim($this->argument('directory'), '/').'/';

		// Make sure that we have all of the files
		foreach($this->order as $file => $table) {
			if(!is_file($this->directory.$file.'.txt')) {
				$this->error($this->directory.$file.'.txt'.' file is missing.');
				$this->continue = false;
			}
		}
		if(!$this->continue) die();

		// Run Truncations
		DB::transaction(function() {
			foreach(array_reverse($this->order) as $file => $table) {
				$this->info('Truncating table '.$table);
				DB::table($table)->delete();
			}
		});

		// Run Imports
		foreach($this->order as $file => $table) {
			$this->importFile($file, $table);
		}
        $this->info('Import done! :)');
	}

	protected function importFile($file, $table) {
		$fullFile = $this->directory.$file.'.txt';
        $tempFile = '/tmp/'.$file.'.txt';

		// Remove leading/trailing spaces from the file
        // Change weird format to CSV
		exec("sed 's/^[ \t]*//;s/[ \t]*$//;s/\"/\"\"/g;s/\^/,/g;s/~/\"/g' {$fullFile} > {$tempFile}");

        // Import standardized file
        $output = []; $return = 0;
        //echo -e '.separator "@"\n.import output log_dump' | sqlite log.db
        //exec("sqlite3 ".Config::get('database.connections.sqlite.database')." '.import {$tempFile} {$table}'", $output, $return);
        exec("echo '.separator ,\n.import {$tempFile} {$table}' | sqlite3 ".Config::get('database.connections.sqlite.database'), $output, $return);
        if (!$return && !$output) {
            $this->info($file.' imported successfully!');
        } else {
            throw new UnexpectedValueException('Import failed');
        }

        exec("rm {$tempFile}");
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
			array('directory', InputArgument::REQUIRED, 'Unzipped SR data file.'),
		);
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array(
			array('update', 'u', InputOption::VALUE_OPTIONAL, 'Import an update file (not yet supported.', false),
		);
	}

}
