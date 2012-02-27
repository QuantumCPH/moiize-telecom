<h1>AgentUser List</h1>

<table>
  <thead>
    <tr>
      <th>Id</th>
      <th>Agent company</th>
      <th>Username</th>
      <th>Password</th>
      <th>Status</th>
      <th>Created at</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($agent_user_list as $agent_user): ?>
    <tr>
      <td><a href="<?php echo url_for('agentUser/edit?id='.$agent_user->getId()) ?>"><?php echo $agent_user->getId() ?></a></td>
      <td><?php echo $agent_user->getAgentCompanyId() ?></td>
      <td><?php echo $agent_user->getUsername() ?></td>
      <td><?php echo $agent_user->getPassword() ?></td>
      <td><?php echo $agent_user->getStatusId() ?></td>
      <td><?php echo $agent_user->getCreatedAt() ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

  <a href="<?php echo url_for('agentUser/new') ?>">New</a>
