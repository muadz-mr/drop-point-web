export function usePagination(response) {
  const data = response.data;

  const pagination = {
    currentPage: response.current_page,
    lastPage: response.last_page,
    perPage: response.per_page,
    total: response.total,
    links: response.links
  };

  return { data, pagination };
}