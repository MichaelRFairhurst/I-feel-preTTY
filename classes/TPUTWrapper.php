<?php

class TPUTWrapper {

	function getLines() {
		return `tput lines`;
	}

	function getColumns() {
		return `tput cols`;
	}

}
