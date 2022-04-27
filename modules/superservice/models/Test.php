<?php
namespace modules\superservice\models;

use JMS\Serializer\Annotation as Serializer;
class Test
{
    /**
     * @Serializer\Type("integer")
     */
    private int $internalId;

    /**
     * @Serializer\Type("string")
     */
    private string $name;

    /**
     * @Serializer\Type("int")
     */
    private int $yearStart;

    /**
     * @Serializer\Type("int")
     */
    private int $yearEnd;

    /**
     * @Serializer\Type("int")
     */
    private int $campaignTypeId;

    /**
     * @Serializer\Type("int")
     */
    private int $campaignStatusId;

    /**
     * @Serializer\Type("int")
     */
    private int $maxCountAchievements;

    /**
     * @Serializer\Type("int")
     */
    private int $numberAgree;

    /**
     * @Serializer\Type("int")
     */
    private int $countDirections;

    /**
     * @Serializer\Type("DateTime<'Y-m-d'>")
     */
    private \DateTime $endDate;


    public function getInternalId(): int
    {
        return $this->internalId;
    }

    public function setInternalId(int $internalId): self
    {
        $this->internalId = $internalId;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getYearStart(): int
    {
        return $this->yearStart;
    }

    public function setYearStart(int $yearStart): self
    {
        $this->yearStart = $yearStart;
        return $this;
    }

    public function getYearEnd(): int
    {
        return $this->yearEnd;
    }

    public function setYearEnd(int $yearEnd): self
    {
        $this->yearEnd = $yearEnd;
        return $this;
    }

    public function getCampaignTypeId(): int
    {
        return $this->campaignTypeId;
    }

    public function setCampaignTypeId(int $campaignTypeId): self
    {
        $this->campaignTypeId = $campaignTypeId;
        return $this;
    }

    public function getCampaignStatusId(): int
    {
        return $this->campaignStatusId;
    }

    public function setCampaignStatusId(int $campaignStatusId): self
    {
        $this->campaignStatusId = $campaignStatusId;
        return $this;
    }

    public function getMaxCountAchievements(): int
    {
        return $this->maxCountAchievements;
    }

    public function setMaxCountAchievements(int $maxCountAchievements): self
    {
        $this->maxCountAchievements = $maxCountAchievements;
        return $this;
    }

    public function getNumberAgree(): int
    {
        return $this->numberAgree;
    }

    public function setNumberAgree(int $numberAgree): self
    {
        $this->numberAgree = $numberAgree;
        return $this;
    }

    public function getCountDirections(): int
    {
        return $this->countDirections;
    }

    public function setCountDirections(int $countDirections): self
    {
        $this->countDirections = $countDirections;
        return $this;
    }

    public function getEndDate(): \DateTime
    {
        return $this->endDate;
    }

    public function setEndDate(\DateTime $endDate): self
    {
        $this->endDate = $endDate;
        return $this;
    }
}