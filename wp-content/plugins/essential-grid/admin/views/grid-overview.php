<?php
/**
 * Represents the view for the administration dashboard.
 *
 * This includes the header, options, and other information that should provide
 * The User Interface to the end user.
 *
 * @package   Essential_Grid
 * @author    ThemePunch <info@themepunch.com>
 * @link      http://www.themepunch.com/essential/
 * @copyright 2021 ThemePunch
 */

if (!defined('ABSPATH')) exit();

$order = false;
//order=asc&orderby=name
$selected = array('shortcode' => false, 'last_modified' => false, 'favorite' => false, 'name' => false, 'id' => false);

$saved_sorting = get_option('eg-current-sorting', array());

if (isset($_GET['orderby']) && isset($_GET['order'])) {
	$saved_sorting['orderby'] = esc_attr($_GET['orderby']);
	$saved_sorting['order'] = esc_attr($_GET['order']);
}

if (isset($_GET['limit'])) $saved_sorting['limit'] = esc_attr($_GET['limit']);
if (isset($_GET['pagenum'])) $saved_sorting['pagenum'] = esc_attr($_GET['pagenum']);

update_option('eg-current-sorting', $saved_sorting);

if (isset($saved_sorting['orderby']) && isset($saved_sorting['order'])) {
	$order = array();
	switch ($saved_sorting['orderby']) {
		case 'shortcode':
			$order['handle'] = ($saved_sorting['order'] == 'asc') ? 'ASC' : 'DESC';
			$selected['shortcode'] = ($saved_sorting['order'] == 'desc') ? 'asc' : 'desc';
			break;
		case 'last_modified':
			$order['last_modified'] = ($saved_sorting['order'] == 'asc') ? 'ASC' : 'DESC';
			$selected['last_modified'] = ($saved_sorting['order'] == 'desc') ? 'asc' : 'desc';
			break;
		case 'favorite':
			$order['favorite'] = ($saved_sorting['order'] == 'asc') ? 'ASC' : 'DESC';
			$selected['favorite'] = ($saved_sorting['order'] == 'desc') ? 'asc' : 'desc';
			break;
		case 'id':
			$order['id'] = ($saved_sorting['order'] == 'asc') ? 'ASC' : 'DESC';
			$selected['id'] = ($saved_sorting['order'] == 'desc') ? 'asc' : 'desc';
			break;
		case 'name':
		default:
			$order['name'] = ($saved_sorting['order'] == 'asc') ? 'ASC' : 'DESC';
			$selected['name'] = ($saved_sorting['order'] == 'desc') ? 'asc' : 'desc';
			break;
	}
}

$grids = Essential_Grid::get_essential_grids($order, false);

$limit = (isset($saved_sorting['limit']) && intval($saved_sorting['limit']) > 0) ? intval($saved_sorting['limit']) : 10;
$otype = 'reg';
$total = 0;

$pagenum = isset($saved_sorting['pagenum']) ? absint($saved_sorting['pagenum']) : 1;
$offset = ($pagenum - 1) * $limit;

$cur_offset = 0;

?>
<h2 class="topheader"><?php esc_html_e('Overview', ESG_TEXTDOMAIN); ?><a target="_blank" class="esg-help-button esg-btn esg-red"
																		 href="https://www.essential-grid.com/help-center/"><i 
	class="material-icons">help</i><?php esc_html_e('Help Center', ESG_TEXTDOMAIN); ?></a></h2>
<div id="create_import_grid_wrap">
	<a class='esg-btn-big esg-purple' href='<?php echo $this->getViewUrl(Essential_Grid_Admin::VIEW_GRID_CREATE, 'create=true'); ?>'><i class="material-icons">apps</i><?php esc_html_e('Create Empty Grid', ESG_TEXTDOMAIN); ?></a>
	<a class='esg-btn-big esg-green' id='esg-library-open' href='javascript:void(0);'><i class="material-icons">photo_library</i><?php esc_html_e('Create Grid from Template', ESG_TEXTDOMAIN); ?></a>
</div>
<div class="div35"></div>
<div class="esg-p-relative">
	<?php if (!empty($grids) && is_array($grids)) { ?>
		<div class="view_title"><?php esc_html_e("Your Current Grids", ESG_TEXTDOMAIN); ?></div>
	<?php } ?>
	<div id="search_and_amount">
		<input type="text" id="esg-search-grids" placeholder="<?php esc_attr_e('Search Listed Grids', ESG_TEXTDOMAIN); ?>">
		<form id="ess-pagination-form" action="?page=essential-grid&pagenum=1" method="GET">
			<input type="hidden" name="page" value="essential-grid"/>
			<input type="hidden" name="pagenum" value="1"/>
			<select name="limit" onchange="this.form.submit()">
				<option <?php echo ($limit == 10) ? 'selected="selected"' : ''; ?> value="5">5</option>
				<option <?php echo ($limit == 10) ? 'selected="selected"' : ''; ?> value="10">10</option>
				<option <?php echo ($limit == 25) ? 'selected="selected"' : ''; ?> value="25">25</option>
				<option <?php echo ($limit == 50) ? 'selected="selected"' : ''; ?> value="50">50</option>
				<option <?php echo ($limit == 9999) ? 'selected="selected"' : ''; ?> value="9999"><?php esc_html_e('All', ESG_TEXTDOMAIN); ?></option>
			</select>
		</form>
	</div>
</div>

<div id="eg-grid-overview-wrapper">
	<?php if (!empty($grids) && is_array($grids)) { ?>
		<esg-row class="esg_table_labels">
			<esg-cell class="cell_0">
				<div class="eg-mini-sort-wrapper">
					<a href="?page=essential-grid&orderby=favorite&order=<?php echo ($selected['favorite'] !== false) ? $selected['favorite'] : 'asc'; ?>" class=" "><i class="eg-icon-star-empty"></i></a>
				</div>
			</esg-cell>
			<esg-cell class="cell_1">
				<div class="eg-mini-sort-wrapper">
					<a href="?page=essential-grid&orderby=id&order=<?php echo ($selected['id'] !== false) ? $selected['id'] : 'asc'; ?>" class=" "><?php esc_html_e('ID', ESG_TEXTDOMAIN); ?></a>
				</div>
			</esg-cell>
			<esg-cell class="cell_2">
				<div class="eg-mini-sort-wrapper">
					<a href="?page=essential-grid&orderby=name&order=<?php echo ($selected['name'] !== false) ? $selected['name'] : 'asc'; ?>" class=" "><?php esc_html_e('Name', ESG_TEXTDOMAIN); ?></a>
				</div>
			</esg-cell>
			<esg-cell class="cell_3">
				<div class="eg-mini-sort-wrapper">
					<a href="?page=essential-grid&orderby=shortcode&order=<?php echo ($selected['shortcode'] !== false) ? $selected['shortcode'] : 'asc'; ?>" class=" "><?php esc_html_e('Shortcode', ESG_TEXTDOMAIN); ?></a>
				</div>
			</esg-cell>
			<esg-cell class="cell_4"><?php esc_html_e('Actions', ESG_TEXTDOMAIN); ?> </esg-cell>
			<esg-cell class="cell_5"><?php esc_html_e('Settings', ESG_TEXTDOMAIN); ?> </esg-cell>
			<esg-cell class="cell_6">
				<div class="eg-mini-sort-wrapper">
					<a href="?page=essential-grid&orderby=last_modified&order=<?php echo ($selected['last_modified'] !== false) ? $selected['last_modified'] : 'asc'; ?>" class=" "><?php esc_html_e('Modified', ESG_TEXTDOMAIN); ?></a>
				</div>
			</esg-cell>
		</esg-row>

		<div id="esg-grid-list">
			<?php
			foreach ($grids as $grid) {
				$total++;
				$cur_offset++;
				if ($cur_offset <= $offset) continue; //if we are lower then the offset, continue;
				if ($cur_offset > $limit + $offset) continue; // if we are higher then the limit + offset, continue

				$skin_id = (isset($grid->params['entry-skin'])) ? $grid->params['entry-skin'] : '';
				?>
				<esg-row>
					<esg-cell class="cell_0"><a href="javascript:void(0);" class="eg-toggle-favorite"
						id="eg-star-id-<?php echo $grid->id; ?>"><i class="eg-icon-star<?php
						echo (isset($grid->settings['favorite']) && $grid->settings['favorite'] == 'true') ? '' : '-empty';
						?>"></i></a></esg-cell>
					<esg-cell class="cell_1"><?php echo $grid->id; ?></esg-cell>
					<esg-cell class="cell_2"><?php echo $grid->name; ?></esg-cell>
					<esg-cell class="cell_3">[ess_grid alias="<?php echo $grid->handle; ?>"][/ess_grid]</esg-cell>
					<esg-cell class="cell_4">
						<div class="btn-wrap-overview btn-wrap-overview-<?php echo $grid->id; ?>"><!--
							--><a class="esg-btn esg-purple" href="<?php echo Essential_Grid_Base::getViewUrl(Essential_Grid_Admin::VIEW_GRID_CREATE, 'create=' . $grid->id); ?>"><!--
							--><i class="eg-icon-cog"></i><!--
							--><esg-btntxt><?php esc_html_e("Settings", ESG_TEXTDOMAIN); ?></esg-btntxt><!--
							--></a><!--
							--><a class="esg-btn esg-green" href="<?php echo Essential_Grid_Base::getViewUrl(Essential_Grid_Admin::VIEW_ITEM_SKIN_EDITOR, 'create=' . $skin_id); ?>" target="_blank"><!--
							--><i class="eg-icon-droplet"></i><!--
							--><esg-btntxt><?php esc_html_e("Edit Skin", ESG_TEXTDOMAIN); ?></esg-btntxt><!--
							--></a><!--
							--><a class="esg-btn esg-red eg-btn-delete-grid" id="eg-delete-<?php echo $grid->id; ?>" href="javascript:void(0)"><!--
							--><i class="eg-icon-trash"></i><!--
							--></a><!--
							--><a class="esg-btn esg-blue eg-btn-duplicate-grid" id="eg-duplicate-<?php echo $grid->id; ?>" href="javascript:void(0)"><!--
							--><i class="eg-icon-picture"></i><!--
							--></a><!--
					--></div>
					</esg-cell>
					<esg-cell class="cell_5">
						<?php
						$layer = (isset($grid->params['layout'])) ? $grid->params['layout'] : 'even';
						echo ucfirst($layer);
						if ($layer == 'even')
							echo ', ' . $grid->params['x-ratio'] . ':' . $grid->params['y-ratio'];

						if (isset($grid->postparams['source-type']))
							echo ', ' . ucfirst($grid->postparams['source-type']);

						if (isset($grid->params['layout-sizing']))
							echo ', ' . ucfirst($grid->params['layout-sizing']);
						?>
					</esg-cell>
					<esg-cell class="cell_6">
						<?php echo @$grid->last_modified; ?>
					</esg-cell>
				</esg-row>
				<?php
			}
			?>
		</div>
		<?php
	}
	?>
</div>

<?php
$num_of_pages = ceil($total / $limit);

$page_links = paginate_links(array(
	'base' => add_query_arg('pagenum', '%#%', ''),
	'format' => '',
	'add_args' => array('limit' => $limit),
	'prev_text' => esc_attr__('&laquo;', ESG_TEXTDOMAIN),
	'next_text' => esc_attr__('&raquo;', ESG_TEXTDOMAIN),
	'total' => $num_of_pages,
	'current' => $pagenum
));
if ($page_links) {
	echo '<div class="ess-pagination-wrap">' . $page_links . '</div>';
}
?>

<?php
require_once('elements/grid-info.php');
require_once('elements/grid-library.php');
Essential_Grid_Dialogs::open_imported_grid();
?>

<script type="text/javascript">
	try {
		jQuery('.mce-notification-error').remove();
		jQuery('#wpbody-content >.notice').remove();
	} catch (e) {

	}
	AdminEssentials.initOverviewGrid();
</script>
