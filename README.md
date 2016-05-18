##This bundle allows your site in maintenance mode for public or anonymous users, allowing you to see changes made if your user is allowed between roles

composer require jeriveromartinez/maintenance-site-bundle<br/>
<br/>
...<br/>
new J3rm\MaintenanceSiteBundle\J3rmMaintenanceSiteBundle(),

</br>
##configurations parameter
<pre><code>j3rm_maintenance_site:<br/>
      path_enable: /admin <br/>
      name_path_offline: offline<br/>
      roles_enable_offline: [ROLE_USER,ROLE_ADMIN]<br/>
      maintenance: true<br/></code>
</pre>