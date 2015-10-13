<?php

abstract class ArrayHelper
{
	public static function cmpByDate($a,$b)
	{
		if ($a->getLastMsgDate() > $b->getLastMsgDate()) {
			return -1;
		}
		return 1;
	}
}
