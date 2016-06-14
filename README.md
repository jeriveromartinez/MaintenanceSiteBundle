##This bundle allows your site in maintenance mode for public or anonymous users, allowing you to see changes made if your user is allowed between roles

composer require jeriveromartinez/maintenance-site-bundle<br/>
<br/>
...<br/>
new J3rm\MaintenanceSiteBundle\J3rmMaintenanceSiteBundle(),

</br>
##configurations parameter

<pre><code>j3rm_maintenance_site:<br/>
      path_enable: [/admin,/login] <br/>
      roles_enable_offline: [ROLE_USER,ROLE_ADMIN]<br/>
      maintenance: true<br/></code>
</pre><br/>
Or<br/>
<pre><code>j3rm_maintenance_site:<br/>
      path_enable: [/admin,/login] <br/>
      roles_enable_offline: [ROLE_USER,ROLE_ADMIN]<br/>
      database_offline: YourBundle:YourEntity:attributeName (the attribute most be a boolean)<br/></code>
</pre><br/>
<ul>
<li>path_enable - The administration site url which you must include the login page.</li>
<li>roles_enable_offline - The roles allowed to see the site in development mode.</li>
<li>maintenance - boolean value to enable or not the maintenance mode.</li>
<li>database_offline - It is defined where to catch the value for maintenance mode.</li>
</ul>

<br/>
####this bundle redirect to offline page, for that add this to routing.yml<br/>
<pre><code>
app_offline:<br/>
    resource: "@J3rmMaintenanceSiteBundle/Controller/"<br/>
    type:     annotation<br/>
</code></pre>
####create a error503.html.twig file into "Resources/TwigBundle/views/Exception/"
