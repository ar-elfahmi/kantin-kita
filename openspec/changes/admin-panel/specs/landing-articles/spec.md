## ADDED Requirements

### Requirement: Landing page renders a "Tentang Kami" section from articles

The system SHALL render a section on the public landing page that displays articles whose `status = 'published'` and `kategori = 'tentang-kami'`, ordered by `published_at` descending.

#### Scenario: Published article appears
- **WHEN** an anonymous visitor opens `/`
- **AND** at least one article exists with status=`published` and kategori=`tentang-kami`
- **THEN** the landing page SHALL display a "Tentang Kami" section listing each such article with its judul, ringkasan, gambar_sampul (or placeholder), and published_at

#### Scenario: Draft article is hidden
- **WHEN** an article has status=`draft` and kategori=`tentang-kami`
- **THEN** the landing page SHALL NOT include that article

#### Scenario: Archived article is hidden
- **WHEN** an article has status=`archived` and kategori=`tentang-kami`
- **THEN** the landing page SHALL NOT include that article
- **AND** the article SHALL still be editable from the admin panel

#### Scenario: Articles in other categories are hidden from this section
- **WHEN** a published article has a kategori other than `tentang-kami` (e.g. `berita`)
- **THEN** the "Tentang Kami" section SHALL NOT display it

#### Scenario: Section omitted when no eligible articles
- **WHEN** no article satisfies the visibility rule
- **THEN** the landing page SHALL omit the "Tentang Kami" section entirely (or render an empty-state per design) without errors

#### Scenario: Ordering
- **WHEN** multiple eligible articles exist
- **THEN** the landing page SHALL display them ordered by `published_at` descending

#### Scenario: Payload stays small
- **WHEN** the landing page query runs
- **THEN** the system SHALL only select `id`, `judul`, `slug`, `ringkasan`, `gambar_sampul`, and `published_at` for the listing (full `konten` is not loaded for the landing render)
