<?php
	/**
 * @author Gasper Kozak
 * @copyright 2007-2011

    This file is part of WideImage.
		
    WideImage is free software; you can redistribute it and/or modify
    it under the terms of the GNU Lesser General Public License as published by
    the Free Software Foundation; either version 2.1 of the License, or
    (at your option) any later version.
		
    WideImage is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU Lesser General Public License for more details.
		
    You should have received a copy of the GNU Lesser General Public License
    along with WideImage; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA

	* @package Internals
  **/

namespace YourProject\Utils\WideImage;

use YourProject\Utils\WideImage\Exception\WideImage_UnknownImageOperationException;
use YourProject\Utils\WideImage\Operation\WideImage_Operation_AddNoise;
use YourProject\Utils\WideImage\Operation\WideImage_Operation_ApplyConvolution;
use YourProject\Utils\WideImage\Operation\WideImage_Operation_ApplyFilter;
use YourProject\Utils\WideImage\Operation\WideImage_Operation_ApplyMask;
use YourProject\Utils\WideImage\Operation\WideImage_Operation_AsGrayscale;
use YourProject\Utils\WideImage\Operation\WideImage_Operation_AsNegative;
use YourProject\Utils\WideImage\Operation\WideImage_Operation_AutoCrop;
use YourProject\Utils\WideImage\Operation\WideImage_Operation_CopyChannelsPalette;
use YourProject\Utils\WideImage\Operation\WideImage_Operation_CopyChannelsTrueColor;
use YourProject\Utils\WideImage\Operation\WideImage_Operation_CorrectGamma;
use YourProject\Utils\WideImage\Operation\WideImage_Operation_Crop;
use YourProject\Utils\WideImage\Operation\WideImage_Operation_Flip;
use YourProject\Utils\WideImage\Operation\WideImage_Operation_GetMask;
use YourProject\Utils\WideImage\Operation\WideImage_Operation_Merge;
use YourProject\Utils\WideImage\Operation\WideImage_Operation_Mirror;
use YourProject\Utils\WideImage\Operation\WideImage_Operation_Resize;
use YourProject\Utils\WideImage\Operation\WideImage_Operation_ResizeCanvas;
use YourProject\Utils\WideImage\Operation\WideImage_Operation_Rotate;
use YourProject\Utils\WideImage\Operation\WideImage_Operation_RoundCorners;
use YourProject\Utils\WideImage\Operation\WideImage_Operation_Unsharp;

/**
	 * Operation factory
	 * 
	 * @package Internals
	 **/
	class WideImage_OperationFactory
	{
		static protected $cache = array();
		
		static function get($operationName)
		{
			$lcname = strtolower($operationName);
			if (!isset(self::$cache[$lcname]))
			{
                switch (ucfirst($operationName)) {
                    case 'Resize':
                        self::$cache[$lcname] = new WideImage_Operation_Resize();
                        break;
                    case 'Crop':
                        self::$cache[$lcname] = new WideImage_Operation_Crop();
                        break;
                    default:
                        break;
                }
			}
			return self::$cache[$lcname];
		}
	}
