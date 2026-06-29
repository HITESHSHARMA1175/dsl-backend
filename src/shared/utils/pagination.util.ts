export interface PaginationMeta {
  total: number;
  per_page: number;
  current_page: number;
  last_page: number;
  next_page_url: string | null;
  prev_page_url: string | null;
}

export function calculatePagination(
  total: number,
  page: number,
  perPage: number
): PaginationMeta {
  const lastPage = Math.max(1, Math.ceil(total / perPage));
  const currentPage = Math.max(1, Math.min(page, lastPage));

  return {
    total,
    per_page: perPage,
    current_page: currentPage,
    last_page: lastPage,
    next_page_url: currentPage < lastPage ? `?page=${currentPage + 1}&per_page=${perPage}` : null,
    prev_page_url: currentPage > 1 ? `?page=${currentPage - 1}&per_page=${perPage}` : null,
  };
}
