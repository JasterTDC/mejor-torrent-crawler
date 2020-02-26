<?php

namespace BestThor\ScrappingMaster\Application\UseCase\ElementGeneral;

use BestThor\ScrappingMaster\Domain\General\ElementGeneralEmptyException;
use BestThor\ScrappingMaster\Domain\General\ElementGeneralReaderRepositoryInterface;

/**
 * Class GetElementGeneralDetailUseCase
 *
 * @package BestThor\ScrappingMaster\Application\UseCase\ElementGeneral
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class GetElementGeneralDetailUseCase
{

    /**
     * @var ElementGeneralReaderRepositoryInterface
     */
    protected $elementGeneralReaderRepository;

    /**
     * GetElementGeneralDetailUseCase constructor.
     *
     * @param ElementGeneralReaderRepositoryInterface $elementGeneralReaderRepository
     */
    public function __construct(
        ElementGeneralReaderRepositoryInterface $elementGeneralReaderRepository
    ) {
        $this->elementGeneralReaderRepository = $elementGeneralReaderRepository;
    }

    /**
     * @param GetElementGeneralDetailRequest $request
     *
     * @return GetElementGeneralDetailResponse
     * @throws ElementGeneralEmptyException
     */
    public function handle(
        GetElementGeneralDetailRequest $request
    ): GetElementGeneralDetailResponse {
        $elementGeneral = $this
            ->elementGeneralReaderRepository
            ->getById(
                $request->getElementGeneralId()
            );

        return new GetElementGeneralDetailResponse(
            true,
            null,
            $elementGeneral
        );
    }
}
