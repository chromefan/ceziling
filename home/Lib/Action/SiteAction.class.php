<?php
//计划任务中应该只有software()和category(),其他生成直接放到category()里面
class SiteAction extends BaseAction {
	
	private $perPage = 50000;
	
	private $app_path;
	
	//构造函数
	public function _init() {
		
		$this->app_path = SITE_PATH;
	}
	
	/*
	 * 生成torrent的sitemap
	 */
	public function create() {		

		$file = $this->app_path . '/sitemap.xml';
		$xml = '<?xml version="1.0" encoding="UTF-8" ?>';
		$xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
		
		@unlink ( $file );
		$handle = fopen ( $file, 'a+' );
		fwrite ( $handle, $xml );
			

		$menu =$this->setMenu();
		$xml = '';
		foreach ( $menu as $v ) {
				$xml .= '<url>';
				$xml .= '<loc>' .$v['url']. '</loc>';
				$xml .= '<lastmod>' . date ( 'c' ) . '</lastmod>';
				$xml .= '<changefreq>daily</changefreq>';
				$xml .= '</url>';
		}
		$gua=M('s_gua')->select();
		foreach($gua as $k =>$v){
				$xml .= '<url>';
				$xml .= '<loc>' .$this->base_url.'/'.$v['id']. '.html</loc>';
				$xml .= '<lastmod>' . date ( 'c' ) . '</lastmod>';
				$xml .= '<changefreq>daily</changefreq>';
				$xml .= '</url>';
		}
		fwrite ( $handle, $xml );
		fwrite ( $handle, '</urlset>' );
		fclose ( $handle );
		echo "\n done \n";
	}
}
?>