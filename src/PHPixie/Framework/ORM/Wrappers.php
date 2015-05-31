<?php

namespace PHPixie\Framework\ORM;

class Wrappers
{
    protected $wrappersMap;
    protected $maps;
    protected $names;
    
    public function __construct($bundles)
    {
        
        foreach($bundles as $bundleName => $bundle) {
            $ormWrappers = $bundle->ormWrappers();
            if($ormWrappers === null) {
                continue;
            }
            
            $types = array(
                'databaseRepositories' => $ormWrappers->databaseRepositories(),
                'databaseQueries'      => $ormWrappers->databaseQueries(),
                'databaseEntities'     => $ormWrappers->databaseEntities(),
                'embeddedEntities'     => $ormWrappers->embeddedEntities(),
            );
            
            foreach($types as $type => $names) {
                foreach($names as $name) {
                    $this->maps[$type][$name] = $bundleName;
                }
            }
        }
        
        foreach($this->maps as $type => $map) {
            $this->names[$type] = array_keys($map);
        }
    }
    
    public function databaseRepositoryWrapper($repository)
    {
        return $this
            ->wrapper('databaseQuery',$query->modelName())
            ->databaseQueryWrapper($query);
    }
    
    public function databaseQueryWrapper($query)
    {
        return $this
            ->wrapper('databaseQuery',$query->modelName())
            ->databaseQueryWrapper($query);
    }
    
    public function databaseEntityWrapper($entity)
    {
        return $this
            ->wrapper('databaseEntity',$entity->modelName())
            ->databaseQueryWrapper($entity);
    }
    
    public function embeddedEntityWrapper($entity)
    {
        return $this
            ->wrapper('embeddedEntity',$entity->modelName())
            ->databaseQueryWrapper($entity);
    }
    
    public function databaseRepositories()
    {
        return $this->databaseRepositories;
    }
    
    public function databaseQueries()
    {
        return $this->databaseQueries;
    }
    
    public function databaseEntities()
    {
        return $this->databaseEntities;
    }
    
    public function embeddedEntities()
    {
        return $this->embeddedEntities;
    }
}