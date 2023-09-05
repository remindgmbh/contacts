<?php

declare(strict_types=1);

namespace Remind\Contacts\Domain\Model;

use Remind\Extbase\Domain\Model\AbstractJsonSerializableEntity;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

class Contact extends AbstractJsonSerializableEntity
{
    protected string $firstName = '';

    protected string $lastName = '';

    protected string $middleName = '';

    protected int $salutation = 0;

    protected string $title = '';

    protected string $phone = '';

    protected string $email = '';

    protected string $mobile = '';

    protected string $address = '';

    protected string $slug = '';

    protected string $position = '';

    /**
     * @var ObjectStorage<Group> $groups
     */
    protected ObjectStorage $groups;

    /**
     * @var FileReference|null
     */
    protected ?FileReference $image = null;

    protected ?FileReference $vcard = null;

    public function getDisplayName(): string
    {
        $configurationManager = GeneralUtility::makeInstance(ConfigurationManagerInterface::class);
        $settings = $configurationManager->getConfiguration(
            ConfigurationManagerInterface::CONFIGURATION_TYPE_SETTINGS,
            'contacts'
        );
        $propertyNames = $settings['displayNameFields'];
        $properties = [];
        foreach (GeneralUtility::trimExplode(',', $propertyNames, true) as $propertyName) {
            if ($this->_hasProperty($propertyName)) {
                $properties[] = $this->_getProperty($propertyName);
            }
        }
        return implode(' ', array_filter($properties));
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getMiddleName(): string
    {
        return $this->middleName;
    }

    public function setMiddleName(string $middleName): self
    {
        $this->middleName = $middleName;

        return $this;
    }

    public function getSalutation(): int
    {
        return $this->salutation;
    }

    public function setSalutation(int $salutation): self
    {
        $this->salutation = $salutation;

        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getMobile(): string
    {
        return $this->mobile;
    }

    public function setMobile(string $mobile): self
    {
        $this->mobile = $mobile;

        return $this;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function addGroup(Group $group)
    {
        $this->groups->attach($group);
    }

    public function removeGroup(Group $group)
    {
        $this->groups->detach($group);
    }

    /**
     * @return ObjectStorage<Group>
     */
    public function getGroups(): ObjectStorage
    {
        return $this->groups;
    }

    /**
     * @param ObjectStorage<Group> $groups
     */
    public function setGroups(ObjectStorage $groups): self
    {
        $this->groups = $groups;

        return $this;
    }

    /**
     * @return FileReference|null
     */
    public function getImage(): ?FileReference
    {
        return $this->image;
    }

    /**
     * @param FileReference $image
     */
    public function setImage(FileReference $image): self
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return string
     */
    public function getPosition(): string
    {
        return $this->position;
    }

    public function setPosition(string $position): self
    {
        $this->position = $position;

        return $this;
    }

    /**
     * @return FileReference|null
     */
    public function getVcard(): ?FileReference
    {
        return $this->vcard;
    }

    /**
     * @param FileReference $vcard
     */
    public function setVcard(FileReference $vcard): self
    {
        $this->vcard = $vcard;

        return $this;
    }
}
