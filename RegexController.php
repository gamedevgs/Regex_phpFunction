<?php

namespace frontend\controllers;

use common\components\fe\controllers\FeController as Controller;


class RegexController extends Controller
{

	public $content = <<<HTML
<div class="VCSortableInPreviewMode" type="Photo" style=""><div><img src="https://cdn.tuoitre.vn/thumb_w/640/2018/11/12/logo-mv1-1542036934411321272654.jpg" id="img_7714" w="2000" h="1337" alt="19 nhà gỗ xây dựng trái phép trong thắng cảnh quốc gia hồ Tuyền Lâm - Ảnh 1." title="19 nhà gỗ xây dựng trái phép trong thắng cảnh quốc gia hồ Tuyền Lâm - Ảnh 1." rel="lightbox" photoid="7714" type="photo" style="max-width:100%;" data-original="https://cdn.tuoitre.vn/2018/11/12/logo-mv1-1542036934411321272654.jpg" width="" height=""></div><div class="PhotoCMS_Caption"><p data-placeholder="[nhập chú thích]" class="">19 căn nhà gỗ được chủ đầu tư xây dựng trái phép trong khu nghỉ dưỡng cao cấp và du lịch sinh thái Hoàng Gia, ngay những vị trí cần bảo vệ nghiêm ngặt, nhằm nới rộng không gian kinh doanh - Ảnh: M.VINH</p></div></div>
HTML;

	public function actionRender()
	{
		$this->repaclement();
	}

	public function repaclement()
	{
		$pattern1 = '/(\<div\>)(\<img[^\>]*\>)/i';

		$pattern2 = '/([\w\-]+)\=\"([^\"]*)\"/i';

		preg_match_all($pattern1, $this->content, $object1);

		if (!empty($object1[2]))
		{
			foreach ($object1[2] as $key)
			{
				preg_match_all($pattern2, $key, $object2);

				if (!empty($object2[2]))
				{
//	$object2[2][0] = https://cdn.tuoitre.vn/thumb_w/640/2018/11/12/logo-mv1-1542036934411321272654.jpg
//	$object2[2][5] = 19 nhà gỗ xây dựng trái phép trong thắng cảnh quốc gia hồ Tuyền Lâm - Ảnh 1
					if ((isset($object2[2][0]) && $object2[2][0] != '') && (isset($object2[2][5]) && $object2[2][5] != ''))
					{
//						$text = '<figure data-fancybox="gallery" href="' . $object2[2][0] . '" data-caption="' . $object2[2][5] . '" class="img-cover fancybox">
//								<img src="' . $object2[2][0] . '" alt="' . $object2[2][5] . '">
//                    			<figcaption>' . $object2[2][5] . '</figcaption>
//                				</figure>';
$text = <<<HTML
<figure data-fancybox="gallery" href="{$object2[2][0]}" data-caption="{$object2[2][5]}" class="img-cover fancybox">
<img src="{$object2[2][0]}" alt="{$object2[2][5]}">
<figcaption>{$object2[2][5]}</figcaption>
</figure>
HTML;
						//remove < >
						$text1 = preg_replace('/(^\<)|(\>$)/', '', $text);
						//replace content
						$text2 = preg_replace($key, $text1, $this->content);
						//remove <div> and </div>
						$text3 = preg_replace('/<\/?div>/', '', $text2);
//						debug($cons);
						echo $text3;
					}
				}
			}
		}
	}
}