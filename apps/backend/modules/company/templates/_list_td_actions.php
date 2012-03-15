<td>
<ul class="sf_admin_td_actions">
  <li><?php echo link_to(image_tag('/sf/sf_admin/images/edit_icon.png', array('alt' => __('edit'), 'title' => __('edit'))), 'company/edit?id='.$company->getId()) ?></li>
  <li><?php echo link_to(image_tag('/sf/sf_admin/images/default_icon.png', array('alt' => __('view'), 'title' => __('view'))), 'company/view?id='.$company->getId()) ?></li>
</ul>
</td>
