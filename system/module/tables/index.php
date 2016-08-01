<?php
/**
 * @package SyDES
 *
 * @copyright 2011-2015, ArtyGrand <artygrand.ru>
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

class TablesController extends Controller{
	public $name = 'tables';

	public function install(){
		$this->db->exec("CREATE TABLE tables (
		`id` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
		`title` TEXT default '',
		`content` TEXT default '',
		`status` INTEGER default 1
	)");
		$this->registerModule(true);
		$this->response->notify(t('installed'));
		$this->response->redirect('?route=config/modules');
	}

	public function uninstall(){
		$this->db->exec("DROP TABLE IF EXISTS tables");
		$this->unregisterModule();
		$this->response->notify(t('uninstalled'));
		$this->response->redirect('?route=config/modules');
	}

	public function config(){
		$this->response->redirect('?route=tables');
	}

	public function index(){
		$this->load->model('tables');

		$data = array();
		$data['content'] = $this->load->view('tables/list', array(
			'result' => $this->tables_model->getList(),
		));

		$data['meta_title'] = t('module_' . $this->name);
		$data['breadcrumbs'] = H::breadcrumb(array(
			array('title' => t('module_' . $this->name))
		));

		$this->response->data = $data;
	}

	public function add(){
		$this->load->model('tables');
		$id = $this->tables_model->create($this->request->post['title']);
		$this->response->notify(t('saved'));
		$this->response->redirect('?route=' . $this->name . '/edit&id=' . $id);
	}

	public function edit(){
		if (!isset($this->request->get['id'])){
			throw new BaseException(t('error_empty_values_passed'));
		}

		$id = (int)$this->request->get['id'];
		$this->load->model('tables');

		$table = $this->tables_model->read($id);
		$data = array();
		$data['content'] = $this->load->view('tables/edit', array(
			'result' => $table['content'],
		));
		$data['sidebar_right'] = H::saveButton(DIR_SITE . $this->site . '/database.db') . $this->load->view('tables/right', array(
			'result' => $table,
		));
		$data['form_url'] = '?route=tables/save';

		$data['meta_title'] = t('module_' . $this->name);
		$data['breadcrumbs'] = H::breadcrumb(array(
			array('url' => '?route=' . $this->name, 'title' => t('module_' . $this->name)),
			array('title' => t('editing')),
		));

		$this->response->data = $data;
		$this->response->style[] = '/system/module/tables/assets/handsontable.full.css';
		$this->response->script[] = '/system/module/tables/assets/handsontable.full.js';
	}

	public function save(){
		if (!isset($this->request->post['id'])){
			throw new BaseException(t('error_empty_values_passed'));
		}
		$id = (int)$this->request->post['id'];
		$this->load->model('tables');
		$this->tables_model->update(array(
			'id' => $id,
			'title' => $this->request->post['title'],
			'content' => htmlspecialchars_decode($this->request->post['content']),
			'status' => $this->request->post['status']
		));
		$this->response->notify(t('saved'));
		$this->response->redirect('?route=tables/edit&id=' . $id);
	}

	public function delete(){
		if (!isset($this->request->get['id'])){
			throw new BaseException(t('error_empty_values_passed'));
		}
		$this->load->model('tables');
		$this->tables_model->delete((int)$this->request->get['id']);

		$this->response->notify(t('deleted'));
		$this->response->redirect('?route=tables');
	}
}
