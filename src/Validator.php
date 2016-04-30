<?php
namespace Ely\TempMailBuster;

class Validator
{
    /**
     * @var StorageInterface
     */
    private $primaryStorage;
    /**
     * @var StorageInterface|null
     */
    private $secondaryStorage;
    /**
     * @var bool
     */
    private $isWhitelistMode = false;

    /**
     * @param StorageInterface $primaryStorage
     * @param StorageInterface|null $secondaryStorage
     */
    public function __construct(StorageInterface $primaryStorage, StorageInterface $secondaryStorage = null)
    {
        $this->setPrimaryStorage($primaryStorage);
        $this->setSecondaryStorage($secondaryStorage);
    }

    /**
     * Validate passed email over all storage domains and return true if domain not found
     * in lists. False otherwise.
     * @see TempMailBuster::getDomain() for info about accepted $email formats
     *
     * @param string $email
     * @return bool
     */
    public function validate($email)
    {
        $domain = $this->getDomain($email);
        $secondaryStorage = $this->secondaryStorage;
        if ($secondaryStorage === null) {
            $secondaryStorage = new Storage();
        }

        if (!$this->isWhitelistMode) {
            $blacklist = $this->primaryStorage;
            $whitelist = $secondaryStorage;
        } else {
            $blacklist = $secondaryStorage;
            $whitelist = $this->primaryStorage;
        }

        $blacklistRegex = $this->buildRegex($blacklist->getItems());
        $match = !!preg_match($blacklistRegex, $domain);
        if ($match === $this->isWhitelistMode) {
            return !$this->isWhitelistMode;
        }

        $whitelistRegex = $this->buildRegex($whitelist->getItems());
        $match = !!preg_match($whitelistRegex, $domain);

        return $match;
    }

    /**
     * @return StorageInterface
     */
    public function getPrimaryStorage()
    {
        return $this->primaryStorage;
    }

    /**
     * @param StorageInterface $primaryStorage
     * @return static
     */
    public function setPrimaryStorage(StorageInterface $primaryStorage)
    {
        $this->primaryStorage = $primaryStorage;
        return $this;
    }

    /**
     * @return StorageInterface|null
     */
    public function getSecondaryStorage()
    {
        return $this->secondaryStorage;
    }

    /**
     * @param StorageInterface|null $secondaryStorage
     * @return static
     */
    public function setSecondaryStorage(StorageInterface $secondaryStorage = null)
    {
        $this->secondaryStorage = $secondaryStorage;
        return $this;
    }

    /**
     * @return bool is enabled whitelist mode
     */
    public function isIsWhitelistMode()
    {
        return $this->isWhitelistMode;
    }

    /**
     * Switching validator working mode
     *
     * @param bool $enable
     * @return static
     */
    public function whitelistMode($enable = true)
    {
        $this->isWhitelistMode = $enable;
        return $this;
    }

    /**
     * Catches the domain part of passed E-mail address. Expected values is:
     * - full E-mail: erickskrauch@ely.by
     * - domain, starting with @: @ely.by
     * - domain itself: ely.by
     *
     * @param string $email
     * @return string
     */
    protected function getDomain($email)
    {
        $parts = explode('@', $email);
        return array_pop($parts);
    }

    /**
     * @param array $list
     * @return string
     */
    protected function buildRegex(array $list)
    {
        return '/^(' . implode('|', $list) . ')$/';
    }
}
