<?php
namespace Ely\TempMailBuster;

class TempMailBuster
{
    /**
     * @var Storage
     */
    private $storage;

    /**
     * @param Storage $storage
     */
    public function __construct(Storage $storage)
    {
        $this->storage = $storage;
    }

    /**
     * @return Storage
     */
    public function getStorage()
    {
        return $this->storage;
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
        $tempMailsRegex = $this->buildRegex($this->getStorage()->getBlacklist());
        $match = preg_match($tempMailsRegex, $domain);

        // TODO: add support for whitelists

        return !$match;
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
