<?php
/**
 * 抓取远程图片到本地，可以抓取不带有后缀的图片
 * @author YanYing <yanyinghq@163.com>
 * @link bidianer.com
 */
class GrabImage {

	/**
	 * @var string 需要抓取的远程图片的地址
	 * 例如：http://www.bidianer.com/img/icon_mugs.jpg
	 * 有一些远程文件路径可能不带拓展名
	 * 形如：http://www.xxx.com/img/icon_mugs/q/0
	 */
	private $img_url;

	/**
	 * @var string 需要保存的文件名称
	 * 抓取到本地的文件名会重新生成名称
	 * 但是，不带拓展名
	 * 例如：57feefd7e2a7aY5p7LsPqaI-lY1BF
	 */
	private $file_name;

	/**
	 * @var string 文件的拓展名
	 * 这里直接使用远程图片拓展名
	 * 对于没有拓展名的远程图片，会从文件流中获取
	 * 例如：.jpg
	 */
	private $extension;

	/**
	 * @var string 文件保存在本地的目录
	 * 这里的路径是PHP保存文件的路径
	 * 一般相对于入口文件保存的路径
	 * 比如：./uploads/image/201610/19/
	 * 但是该路径一般不直接存储到数据库
	 */
	private $file_dir;

	/**
	 * @var string 数据库保存的文件目录
	 * 这个路径是直接保存到数据库的图片路径
	 * 一般直接保存日期 + 文件名，需要使用的时候拼上前面路径
	 * 这样做的目的是为了迁移系统时候方便更换路径
	 * 例如：201610/19/
	 */
	private $save_dir;

	/**
	 * @param string $img_url 需要抓取的图片地址
	 * @param string $base_dir 本地保存的路径，比如：./uploads/image，最后不带斜杠"/"
	 * @return bool|int
	 */
	public function getInstances($img_url, $base_dir) {
		$this -> img_url = $img_url;
		$this -> save_dir = date("Ym") . '/' . date("d") . '/';
		// 比如：201610/19/
		$this -> file_dir = $base_dir . '/' . $this -> save_dir . '/';
		// 比如：./uploads/image/2016/10/19/
		return $this -> start();
	}

	/**
	 * 开始抓取图片
	 */
	private function start() {
		if ($this -> setDir()) {
			return $this -> getRemoteImg();
		} else {
			return false;
		}
	}

	/**
	 * 检查图片需要保持的目录是否存在
	 * 如果不存在，则立即创建一个目录
	 * @return bool
	 */
	private function setDir() {
		if (!file_exists($this -> file_dir)) {
			mkdir($this -> file_dir, 0777, TRUE);
		}

		$this -> file_name = uniqid() . rand(10000, 99999);
		// 文件名，这里只是演示，实际项目中请使用自己的唯一文件名生成方法

		return true;
	}

	/**
	 * 抓取远程图片核心方法，可以同时抓取有后缀名的图片和没有后缀名的图片
	 *
	 * @return bool|int
	 */
	private function getRemoteImg() {
		// mime 和 扩展名 的映射
		$mimes = array('image/bmp' => 'bmp', 'image/gif' => 'gif', 'image/jpeg' => 'jpg', 'image/png' => 'png', 'image/x-icon' => 'ico');
		// 获取响应头
		if (($headers = get_headers($this -> img_url, 1)) !== false) {
			// 获取响应的类型
			$type = $headers['Content-Type'];
			// 如果符合我们要的类型
			if (isset($mimes[$type])) {
				$this -> extension = $mimes[$type];
				$file_path = $this -> file_dir . $this -> file_name . "." . $this -> extension;
				// 获取数据并保存
				$contents = file_get_contents($this -> img_url);
				if (file_put_contents($file_path, $contents)) {
					// 这里返回出去的值是直接保存到数据库的路径 + 文件名，形如：201610/19/57feefd7e2a7aY5p7LsPqaI-lY1BF.jpg
					return $this -> save_dir . $this -> file_name . "." . $this -> extension;
				}
			}
		}
		return false;
	}

}
