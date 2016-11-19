<?php

namespace J3rm\MaintenanceSiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Sites
 * @package App\GenericBundle\Entity
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Sites
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="site_name", type="string", length=255)
     */
    private $siteName;

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=255, unique=true)
     */
    private $slug;

    /**
     * @var string
     *
     * @ORM\Column(name="domain", type="string", length=255, nullable=true)
     */
    private $domain;

    /**
     * @var boolean
     *
     * @ORM\Column(name="offline", type="boolean", options={"default":false})
     */
    private $offline = false;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set siteName
     *
     * @param string $siteName
     * @return Sites
     */
    public function setSiteName($siteName)
    {
        $this->siteName = $siteName;

        return $this;
    }

    /**
     * Get siteName
     *
     * @return string
     */
    public function getSiteName()
    {
        return $this->siteName;
    }

    /**
     * Set onBuild
     *
     * @param boolean $offline
     * @return Sites
     */
    public function setOffline($offline)
    {
        $this->offline = $offline;

        return $this;
    }

    /**
     * Get onBuild
     *
     * @return boolean
     */
    public function getOffline()
    {
        return $this->offline;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return Sites
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set domain
     *
     * @param string $domain
     * @return Sites
     */
    public function setDomain($domain)
    {
        $this->domain = $domain;

        return $this;
    }

    /**
     * Get domain
     *
     * @return string
     */
    public function getDomain()
    {
        return $this->domain;
    }
}
