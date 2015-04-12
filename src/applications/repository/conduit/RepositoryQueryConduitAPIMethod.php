<?php

final class RepositoryQueryConduitAPIMethod
  extends RepositoryConduitAPIMethod {

  public function getAPIMethodName() {
    return 'repository.query';
  }

  public function getMethodStatus() {
    return self::METHOD_STATUS_UNSTABLE;
  }

  public function getMethodStatusDescription() {
    return pht('Repository methods are new and subject to change.');
  }

  public function getMethodDescription() {
    return pht('Query repositories.');
  }

  protected function defineParamTypes() {
    return array(
      'ids' => 'optional list<int>',
      'phids' => 'optional list<phid>',
      'callsigns' => 'optional list<string>',
      'vcsTypes' => 'optional list<string>',
      'remoteURIs' => 'optional list<string>',
      'uuids' => 'optional list<string>',
    );
  }

  protected function defineReturnType() {
    return 'list<dict>';
  }

  protected function execute(ConduitAPIRequest $request) {
    $query = id(new PhabricatorRepositoryQuery())
      ->setViewer($request->getUser());

    $ids = $request->getValue('ids', array());
    if ($ids) {
      $query->withIDs($ids);
    }

    $phids = $request->getValue('phids', array());
    if ($phids) {
      $query->withPHIDs($phids);
    }

    $callsigns = $request->getValue('callsigns', array());
    if ($callsigns) {
      $query->withCallsigns($callsigns);
    }

    $vcs_types = $request->getValue('vcsTypes', array());
    if ($vcs_types) {
      $query->withTypes($vcs_types);
    }

    $remote_uris = $request->getValue('remoteURIs', array());
    if ($remote_uris) {
      $query->withRemoteURIs($remote_uris);
    }

    $uuids = $request->getValue('uuids', array());
    if ($uuids) {
      $query->withUUIDs($uuids);
    }

    $repositories = $query->execute();

    $results = array();
    foreach ($repositories as $repository) {
      $results[] = $repository->toDictionary();
    }

    return $results;
  }

}
